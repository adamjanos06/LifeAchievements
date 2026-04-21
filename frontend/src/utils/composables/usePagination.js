import { ref, computed } from "vue";

/**
 * Composable for managing pagination
 * @param {number} itemsPerPage - Number of items per page (default: 9)
 * @returns {Object} Pagination state and methods
 */
export function usePagination(itemsPerPage = 9) {
  const currentPage = ref(1);
  const perPage = itemsPerPage;

  /**
   * Calculate total pages based on items array length
   */
  const getTotalPages = (items) => {
    return Math.max(1, Math.ceil(items.length / perPage));
  };

  /**
   * Get paginated items
   */
  const getPaginatedItems = (items) => {
    const start = (currentPage.value - 1) * perPage;
    return items.slice(start, start + perPage);
  };

  /**
   * Navigate to a specific page
   */
  const goToPage = (page, maxPages) => {
    if (page >= 1 && page <= maxPages) {
      currentPage.value = page;
    }
  };

  /**
   * Reset to first page
   */
  const resetPage = () => {
    currentPage.value = 1;
  };

  return {
    currentPage,
    perPage,
    getTotalPages,
    getPaginatedItems,
    goToPage,
    resetPage,
  };
}
