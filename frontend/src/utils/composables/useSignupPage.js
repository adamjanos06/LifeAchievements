import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

export function useSignupPage() {
  const router = useRouter()
  const usernamePattern = /^[A-Za-z0-9]+$/
  const name = ref("")
  const email = ref("")
  const password = ref("")
  const password_confirmation = ref("")
  const error = ref("")

  async function register() {
    error.value = ""

    const normalizedName = name.value.trim()

    if (!usernamePattern.test(normalizedName)) {
      error.value = "No symbols or special characters allowed in name."
      return
    }

    if (password.value !== password_confirmation.value) {
      error.value = "Passwords do not match"
      return
    }

    try {
      const res = await axios.post("http://backend.vm1.test/api/register", {
        name: normalizedName,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      })

      localStorage.setItem("token", res.data.token)
      axios.defaults.headers.common.Authorization = `Bearer ${res.data.token}`
      router.push("/catalog")
    } catch (err) {
      if (err.response?.data?.errors) {
        error.value = Object.values(err.response.data.errors).flat().join(" ")
      } else {
        error.value = err.response?.data?.message || "Registration failed."
      }
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
