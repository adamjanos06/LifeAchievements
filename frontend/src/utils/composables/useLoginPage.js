import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

export function useLoginPage() {
  const router = useRouter()
  const email = ref("")
  const password = ref("")
  const error = ref("")
  const loading = ref(false)

  async function login() {
    error.value = ""
    loading.value = true

    try {
      const res = await axios.post("http://backend.vm1.test/api/login", {
        email: email.value,
        password: password.value,
      })

      localStorage.setItem("token", res.data.token)
      axios.defaults.headers.common.Authorization = `Bearer ${res.data.token}`
      router.push("/catalog")
    } catch (err) {
      if (err.response?.status === 422) {
        error.value = Object.values(err.response.data.errors).flat().join(" ")
      } else if (err.response?.status === 401) {
        error.value = "Invalid email or password."
      } else {
        error.value = err.response?.data?.message || "Login failed."
      }
    } finally {
      loading.value = false
    }
  }

  return {
    email,
    password,
    error,
    loading,
    login,
  }
}
