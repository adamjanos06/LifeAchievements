const API_BASE = "http://backend.vm1.test/api";

/**
 * Fetch user's friend list
 * @returns {Promise<Array>} Array of friends
 */
export async function fetchFriends() {
  try {
    const res = await fetch(`${API_BASE}/friends`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch friends");
    const json = await res.json();
    return json.data ?? [];
  } catch (error) {
    console.error("Error fetching friends:", error);
    throw error;
  }
}

/**
 * Fetch friend requests (both sent and received)
 * @returns {Promise<Object>} Object with sent and received friend requests
 */
export async function fetchFriendRequests() {
  try {
    const res = await fetch(`${API_BASE}/friend-requests`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to fetch friend requests");
    return await res.json();
  } catch (error) {
    console.error("Error fetching friend requests:", error);
    throw error;
  }
}

/**
 * Send a friend request
 * @param {number} userId - User ID to send request to
 * @returns {Promise<Object>} Response from server
 */
export async function sendFriendRequest(userId) {
  try {
    const res = await fetch(`${API_BASE}/friends/request/${userId}`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to send friend request");
    return await res.json();
  } catch (error) {
    console.error(`Error sending friend request to ${userId}:`, error);
    throw error;
  }
}

/**
 * Accept a friend request
 * @param {number} userId - User ID to accept request from
 * @returns {Promise<Object>} Response from server
 */
export async function acceptFriendRequest(userId) {
  try {
    const res = await fetch(`${API_BASE}/friends/accept/${userId}`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to accept friend request");
    return await res.json();
  } catch (error) {
    console.error(`Error accepting friend request from ${userId}:`, error);
    throw error;
  }
}

/**
 * Reject a friend request
 * @param {number} userId - User ID to reject request from
 * @returns {Promise<Object>} Response from server
 */
export async function rejectFriendRequest(userId) {
  try {
    const res = await fetch(`${API_BASE}/friends/reject/${userId}`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to reject friend request");
    return await res.json();
  } catch (error) {
    console.error(`Error rejecting friend request from ${userId}:`, error);
    throw error;
  }
}

/**
 * Remove a friend
 * @param {number} userId - User ID to remove as friend
 * @returns {Promise<Object>} Response from server
 */
export async function removeFriend(userId) {
  try {
    const res = await fetch(`http://backend.vm1.test/api/friends/${userId}`, {
      method: "DELETE",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (!res.ok) throw new Error("Failed to remove friend");
    return await res.json();
  } catch (error) {
    console.error(`Error removing friend ${userId}:`, error);
    throw error;
  }
}

// async function removeFriend() {
//   if (!isFriend.value || !user.value?.id) return

//   removingFriend.value = true

//   const res = await fetch(`http://backend.vm1.test/api/friends/${user.value.id}`, {
//     method: "DELETE",
//     headers: {
//       Authorization: `Bearer ${token}`,
//     },
//   })

//   if (!res.ok) {
//     console.error("remove friend failed", await res.text())
//   } else {
//     isFriend.value = false
//     requestSent.value = false
//     await Promise.all([loadFriendRequests(), loadFriendList()])
//   }

//   removingFriend.value = false
// }