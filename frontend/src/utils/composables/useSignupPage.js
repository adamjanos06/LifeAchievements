import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

export function useSignupPage() {
  const router = useRouter()
  const name = ref("")
  const email = ref("")
  const password = ref("")
  const password_confirmation = ref("")
  const error = ref("")

  async function register() {
    error.value = ""

    if (password.value !== password_confirmation.value) {
      error.value = "Passwords do not match"
      return
    }

    try {
      const res = await axios.post("http://backend.vm1.test/api/register", {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      })

      localStorage.setItem("token", res.data.token)
      axios.defaults.headers.common.Authorization = `Bearer ${res.data.token}`
      router.push("/catalog")
    } catch (err) {
      error.value = err.response?.data?.message || "Registration failed."
    }
  }

  return {
    name,
    email,
    password,
    password_confirmation,
    error,
    register,
  }
}
