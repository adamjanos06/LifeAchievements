const API_BASE = "http://backend.vm1.test/api";

/**
 * Fetch user's goals (as achievements)
 * @returns {Promise<Array>} Array of user's goals
 */
export async function fetchGoals() {
  try {
    const token = localStorage.getItem("token");
    const res = await fetch(`${API_BASE}/goals`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch goals");
    const json = await res.json();
    return json.data || [];
  } catch (error) {
    console.error("Error fetching goals:", error);
    throw error;
  }
}

/**
 * Add a goal for an achievement
 * @param {number} achievementId - Achievement ID
 * @returns {Promise<Object>} Response from server
 */
export async function addGoal(achievementId) {
  try {
    const res = await fetch(`${API_BASE}/goals/${achievementId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to add goal");
    return await res.json();
  } catch (error) {
    console.error(`Error adding goal for achievement ${achievementId}:`, error);
    throw error;
  }
}

/**
 * Remove a goal
 * @param {number} achievementId - Achievement ID
 * @returns {Promise<Object>} Response from server
 */
export async function removeGoal(achievementId) {
  try {
    const res = await fetch(`${API_BASE}/goals/${achievementId}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to remove goal");
    return await res.json();
  } catch (error) {
    console.error(`Error removing goal for achievement ${achievementId}:`, error);
    throw error;
  }
}
