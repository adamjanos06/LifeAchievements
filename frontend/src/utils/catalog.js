const API_BASE = "http://backend.vm1.test/api";

/**
 * Convert hex color to RGB and calculate brightness
 * @param {string} hex - Hex color code (e.g., #FF0000)
 * @returns {string} Safe hex color or default blue
 */
export function getSafeColor(hex) {
  if (!hex) return "#3b82f6"

  const clean = hex.replace("#", "").toLowerCase()

  // short hexes
  const full = clean.length === 3
    ? clean.split("").map(c => c + c).join("")
    : clean

  const r = parseInt(full.substring(0, 2), 16)
  const g = parseInt(full.substring(2, 4), 16)
  const b = parseInt(full.substring(4, 6), 16)

  // brightness
  const brightness = (r * 299 + g * 587 + b * 114) / 1000

  // extreme colors
  if (brightness > 220 || brightness < 40) {
    return "#3b82f6"
  }

  return `#${full}`
}

/**
 * Mark achievement as completed
 * @param {number} achievementId - Achievement ID
 * @returns {Promise<Object>} Response from server with potential badge
 */
export async function markAchievementCompleted(achievementId) {
  try {
    const res = await fetch(
      `${API_BASE}/achievements/${achievementId}/complete`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );

    if (!res.ok) throw new Error("Failed to mark achievement as completed");
    return await res.json();
  } catch (error) {
    console.error(`Error marking achievement ${achievementId} as completed:`, error);
    throw error;
  }
}
