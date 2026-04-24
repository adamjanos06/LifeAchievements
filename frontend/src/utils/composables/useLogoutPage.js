import { onMounted } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

export function useLogoutPage() {
  const router = useRouter()

  async function logout() {
    try {
      await axios.post("/logout")
    } catch (e) {
    }

    localStorage.removeItem("token")
    delete axios.defaults.headers.common.Authorization
    router.push("/")
  }

  onMounted(() => {
    logout()
  })

  return {
    logout,
  }
}
