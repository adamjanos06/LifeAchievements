const API_BASE = "http://backend.vm1.test/api";

/**
 * Fetch all categories
 * @returns {Promise<Array>} Array of category objects
 */
export async function fetchCategories() {
  try {
    const res = await fetch(`${API_BASE}/categories`);
    if (!res.ok) throw new Error("Failed to fetch categories");
    const json = await res.json();
    return json.data || [];
  } catch (error) {
    console.error("Error fetching categories:", error);
    throw error;
  }
}

/**
 * Fetch a single category by ID
 * @param {number} id - Category ID
 * @returns {Promise<Object>} Category object
 */
export async function fetchCategory(id) {
  try {
    const res = await fetch(`${API_BASE}/categories/${id}`);
    if (!res.ok) throw new Error("Failed to fetch category");
    const json = await res.json();
    return json.data;
  } catch (error) {
    console.error(`Error fetching category ${id}:`, error);
    throw error;
  }
}
