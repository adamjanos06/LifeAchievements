const API_BASE = "http://backend.vm1.test/api";

/**
 * Get current user profile
 * @returns {Promise<Object>} Current user data
 */
export async function fetchCurrentUser() {
  try {
    const res = await fetch(`${API_BASE}/me`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch user");
    const data = await res.json();
    return data.user;
  } catch (error) {
    console.error("Error fetching current user:", error);
    throw error;
  }
}

/**
 * Get user by ID
 * @param {number} userId - User ID
 * @returns {Promise<Object>} User data
 */
export async function fetchUser(userId) {
  try {
    const res = await fetch(`${API_BASE}/users/${userId}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch user");
    return await res.json();
  } catch (error) {
    console.error(`Error fetching user ${userId}:`, error);
    throw error;
  }
}

/**
 * Trigger profile visited badge check
 * @returns {Promise<Object>} Response with potential badge
 */
export async function checkProfileBadge() {
  try {
    const res = await fetch(`${API_BASE}/profile-visited`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to check profile badge");
    return await res.json();
  } catch (error) {
    console.error("Error checking profile badge:", error);
    throw error;
  }
}

/**
 * Fetch user's earned badges
 * @returns {Promise<Array>} Array of badges
 */
export async function fetchUserBadges() {
  try {
    const res = await fetch(`${API_BASE}/my-badges`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch badges");
    const json = await res.json();
    return json.data ?? [];
  } catch (error) {
    console.error("Error fetching badges:", error);
    throw error;
  }
}
