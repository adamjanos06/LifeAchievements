const API_BASE = "http://backend.vm1.test/api";

/**
 * Get authorization header from localStorage
 * @returns {Object} Headers object with Authorization if token exists
 */
function getAuthHeader() {
  const token = localStorage.getItem("token");
  return token ? { Authorization: `Bearer ${token}` } : {};
}

/**
 * Fetch all achievements
 * @returns {Promise<Array>} Array of achievement objects
 */
export async function fetchAchievements() {
  try {
    const res = await fetch(`${API_BASE}/achievements`, {
      headers: getAuthHeader(),
    });
    if (!res.ok) throw new Error("Failed to fetch achievements");
    const json = await res.json();
    return (json.data || []).map(a => ({
      ...a,
      repeatable: a.repeatable ?? false,
      completions: Number(a.completions) || 0,
    }));
  } catch (error) {
    console.error("Error fetching achievements:", error);
    throw error;
  }
}

/**
 * Fetch user's completed achievements
 * @returns {Promise<Array>} Array of user's completed achievements
 */
export async function fetchMyAchievements() {
  try {
    const res = await fetch(`${API_BASE}/my-achievements`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch my achievements");
    const json = await res.json();
    // Normalize data structure for consistent access
    return (json.data.data ?? json.data ?? []).map(a => ({
      id: a.achievement?.id || a.id,
      name: a.achievement?.name || a.name,
      description: a.achievement?.description || a.description,
      category_id: a.achievement?.category_id || a.category_id,
      category: a.achievement?.category,
      category_icon: a.achievement?.category?.icon,
      repeatable: a.achievement?.repeatable ?? false,
      completions: Number(a.completions) || 0,
      xp: a.achievement?.xp || a.xp,
      difficulty: a.achievement?.difficulty || a.difficulty,
      // Keep original nested structure for backward compatibility
      achievement: a.achievement || {
        id: a.id,
        name: a.name,
        description: a.description,
        repeatable: a.repeatable ?? false,
        category: a.category
      }
    }));
  } catch (error) {
    console.error("Error fetching my achievements:", error);
    throw error;
  }
}

/**
 * Mark an achievement as completed
 * @param {number} achievementId - Achievement ID
 * @returns {Promise<Object>} Response from server
 */
export async function completeAchievement(achievementId) {
  try {
    const res = await fetch(`${API_BASE}/achievements/${achievementId}/complete`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to complete achievement");
    return await res.json();
  } catch (error) {
    console.error(`Error completing achievement ${achievementId}:`, error);
    throw error;
  }
}
