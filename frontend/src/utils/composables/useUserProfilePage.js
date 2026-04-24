import { onMounted, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import { fetchUser } from "@/utils/api/user.js"
import { fetchFriends, fetchFriendRequests } from "@/utils/api/friends.js"

export function useUserProfilePage() {
  const router = useRouter()
  const route = useRoute()
  const user = ref(null)
  const friendList = ref([])
  const isFriend = ref(false)
  const loading = ref(true)
  const unlockedBadge = ref(null)
  const requestSent = ref(false)
  const removingFriend = ref(false)
  const token = localStorage.getItem("token")
  const currentUserId = Number(localStorage.getItem("userId"))

  async function loadUser() {
    try {
      user.value = await fetchUser(route.params.id)
    } catch (error) {
      console.error("Failed to load user:", error)
    }
  }

  async function loadFriendList() {
    if (!token || !user.value?.id) return

    try {
      friendList.value = await fetchFriends()
      const profileUserId = user.value.id
      const profileUserIdNum = Number(profileUserId)

      if (friendList.value.length === 0) {
        isFriend.value = false
      } else {
        const matchedFriend = friendList.value.find((f) => f.id == profileUserId || Number(f.id) === profileUserIdNum)
        isFriend.value = !!matchedFriend
      }
    } catch (error) {
      console.error("Failed to load friend list:", error)
    }
  }

  async function loadFriendRequests() {
    if (!token || !user.value?.id) return

    try {
      const json = await fetchFriendRequests()
      const sent = json.sent || []
      requestSent.value = sent.some(
        (r) => r.receiver?.id === user.value.id || r.receiver?.name === user.value.name
      )
    } catch (error) {
      console.error("Failed to load friend requests:", error)
    }
  }

  async function sendRequest() {
    if (requestSent.value || !user.value) return

    const payload = { name: user.value.name }

    const res = await fetch("http://backend.vm1.test/api/friends", {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json"
      },
      body: JSON.stringify(payload)
    })

    if (!res.ok) {
      console.error("friend request failed", await res.text())
    } else {
      const data = await res.json().catch(() => ({}))
      requestSent.value = true
      isFriend.value = false
      await Promise.all([loadFriendRequests(), loadFriendList()])
      if (data.badge) {
        unlockedBadge.value = data.badge
      }
    }
  }

  function getAvatarUrl(image) {
    if (!image) return null
    const filename = image.split("/").pop()
    return `http://backend.vm1.test/api/avatar/${filename}`
  }

  function goBack() {
    window.history.length > 1 ? router.back() : router.push("/leaderboard")
  }

  onMounted(async () => {
    await loadUser()
    if (!user.value?.id) {
      loading.value = false
      return
    }

    await Promise.all([loadFriendRequests(), loadFriendList()])
    loading.value = false
  })

  return {
    user,
    isFriend,
    loading,
    unlockedBadge,
    requestSent,
    removingFriend,
    currentUserId,
    sendRequest,
    getAvatarUrl,
    goBack,
  }
}
