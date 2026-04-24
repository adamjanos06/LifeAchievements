import { computed, onMounted, ref, watch } from "vue"
import { useRouter } from "vue-router"

export function useLeaderboardPage() {
  const router = useRouter()
  const users = ref([])
  const currentUser = ref(null)
  const loading = ref(true)
  const animatedXp = ref({})
  const mode = ref("global")
  const searchQuery = ref("")

  const filteredUsers = computed(() => {
    const q = searchQuery.value.trim().toLowerCase()
    if (!q) return users.value
    return users.value.filter((u) => u.name?.toLowerCase().includes(q))
  })

  function unwrapUserResponse(payload) {
    return payload?.user ?? payload?.data ?? payload
  }

  async function loadLeaderboard() {
    try {
      if (mode.value === "global") {
        const res = await fetch("http://backend.vm1.test/api/leaderboard")
        const json = await res.json()
        users.value = json?.data ?? json
        return
      }

      const res = await fetch("http://backend.vm1.test/api/friends", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })

      const json = await res.json()

      const meRes = await fetch("http://backend.vm1.test/api/me", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })

      const meData = await meRes.json()
      const me = unwrapUserResponse(meData)
      const friends = json?.data ?? []
      const all = [me, ...friends].filter(Boolean)

      users.value = all.sort((a, b) => (b?.xp ?? 0) - (a?.xp ?? 0))
    } catch (err) {
      console.error("Failed to load leaderboard:", err)
      users.value = []
    }
  }

  async function loadCurrentUser() {
    try {
      const res = await fetch("http://backend.vm1.test/api/me", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      const json = await res.json()
      currentUser.value = unwrapUserResponse(json)
    } catch (err) {
      console.error("Failed to load current user:", err)
      currentUser.value = null
    }
  }

  function goToProfile(id) {
    if (currentUser.value && id === currentUser.value.id) {
      router.push("/profile")
    } else {
      router.push(`/users/${id}`)
    }
  }

  function animateXpValues() {
    animatedXp.value = {}

    users.value.forEach((user) => {
      const id = user?.id
      const target = Number(user?.xp ?? 0)
      if (!id) return

      animatedXp.value[id] = 0
      const step = target > 0 ? Math.ceil(target / 30) : 1

      const interval = setInterval(() => {
        if (animatedXp.value[id] >= target) {
          animatedXp.value[id] = target
          clearInterval(interval)
        } else {
          animatedXp.value[id] += step
        }
      }, 20)
    })
  }

  function getMedal(index) {
    if (index === 0) return "🥇"
    if (index === 1) return "🥈"
    if (index === 2) return "🥉"
    return null
  }

  function getAvatarUrl(image) {
    if (!image) return null
    const filename = image.split("/").pop()
    return `http://backend.vm1.test/api/avatar/${filename}`
  }

  watch(mode, async () => {
    loading.value = true
    await loadLeaderboard()
    animateXpValues()
    loading.value = false
  })

  onMounted(async () => {
    await Promise.all([loadLeaderboard(), loadCurrentUser()])
    animateXpValues()
    loading.value = false
  })

  return {
    users,
    currentUser,
    loading,
    animatedXp,
    mode,
    searchQuery,
    filteredUsers,
    goToProfile,
    getMedal,
    getAvatarUrl,
  }
}
