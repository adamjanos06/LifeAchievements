<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller
{
    /**
     * Map of table names to their Model classes
     */
    private static array $tableModels = [
        'users' => \App\Models\User::class,
        'categories' => \App\Models\Category::class,
        'achievements' => \App\Models\Achievement::class,
        'badges' => \App\Models\Badge::class,
        'completed_achievements' => \App\Models\CompletedAchievement::class,
        'goals' => \App\Models\Goal::class,
        'friend_requests' => \App\Models\friend_request::class,
        'badge_user' => null, // pivot table, handled differently
    ];

    /**
     * Get list of all available tables and their record counts
     */
    public function getTables()
    {
        $tables = [];
        
        foreach (self::$tableModels as $tableName => $modelClass) {
            if ($modelClass) {
                $count = $modelClass::count();
                $tables[] = [
                    'name' => $tableName,
                    'count' => $count,
                ];
            }
        }

        return response()->json([
            'data' => $tables
        ]);
    }

    /**
     * Get all records from a specific table with pagination
     */
    public function getTableRecords(Request $request, string $table)
    {
        // Validate table name exists
        if (!isset(self::$tableModels[$table])) {
            return response()->json([
                'error' => 'Table not found'
            ], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json([
                'error' => 'Table not accessible'
            ], 403);
        }

        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);
        $search = $request->query('search', '');
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'asc');

        $query = $modelClass::query();

        // Simple search across all columns
        if ($search) {
            $query->where(function ($q) use ($search, $modelClass) {
                $columns = DB::getSchemaBuilder()->getColumnListing((new $modelClass)->getTable());
                foreach ($columns as $column) {
                    if ($column !== 'password' && $column !== 'remember_token') {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

        // Pagination
        $records = $query
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $records->items(),
            'columns' => $this->getTableColumns($modelClass),
            'pagination' => [
                'total' => $records->total(),
                'per_page' => $records->perPage(),
                'current_page' => $records->currentPage(),
                'last_page' => $records->lastPage(),
            ]
        ]);
    }

    /**
     * Get a single record by ID
     */
    public function getRecord(string $table, int $id)
    {
        if (!isset(self::$tableModels[$table])) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json(['error' => 'Table not accessible'], 403);
        }

        $record = $modelClass::find($id);
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json([
            'data' => $record,
            'columns' => $this->getTableColumns($modelClass)
        ]);
    }

    /**
     * Create a new record
     */
    public function createRecord(Request $request, string $table)
    {
        if (!isset(self::$tableModels[$table])) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json(['error' => 'Table not accessible'], 403);
        }

        // Get fillable attributes for validation
        $model = new $modelClass();
        $fillable = $model->getFillable();

        // Basic validation - check that required fields are present
        $validated = $request->validate(
            array_combine(
                $fillable,
                array_fill(0, count($fillable), 'nullable')
            )
        );

        $record = $modelClass::create($validated);

        return response()->json([
            'message' => 'Record created successfully',
            'data' => $record
        ], 201);
    }

    /**
     * Update a record
     */
    public function updateRecord(Request $request, string $table, int $id)
    {
        if (!isset(self::$tableModels[$table])) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json(['error' => 'Table not accessible'], 403);
        }

        $record = $modelClass::find($id);
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        // Get fillable attributes for validation
        $fillable = $record->getFillable();
        $validated = $request->validate(
            array_combine(
                $fillable,
                array_fill(0, count($fillable), 'nullable')
            )
        );

        $record->update($validated);

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $record
        ]);
    }

    /**
     * Delete a record
     */
    public function deleteRecord(string $table, int $id)
    {
        if (!isset(self::$tableModels[$table])) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json(['error' => 'Table not accessible'], 403);
        }

        $record = $modelClass::find($id);
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $record->delete();

        return response()->json([
            'message' => 'Record deleted successfully'
        ]);
    }

    /**
     * Get table structure (column information)
     */
    public function getTableStructure(string $table)
    {
        if (!isset(self::$tableModels[$table])) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $modelClass = self::$tableModels[$table];
        if (!$modelClass) {
            return response()->json(['error' => 'Table not accessible'], 403);
        }

        $columns = $this->getTableColumns($modelClass);

        return response()->json([
            'table' => $table,
            'columns' => $columns,
            'fillable' => (new $modelClass())->getFillable()
        ]);
    }

    /**
     * Helper: Get column information for a table
     */
    private function getTableColumns(string $modelClass): array
    {
        $model = new $modelClass();
        $table = $model->getTable();
        
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        
        return $columns;
    }
}
