<script setup>
import { ref, watch } from "vue"
import axios from "axios"

const props = defineProps({
  show: {
    type: Boolean,
    required: true
  },
  user: {
    type: Object,
    required: true
  },
  imageUrl: {
    type: String,
    default: null
  }
})

const emit = defineEmits(['close', 'save'])

const saving = ref(false)
const errorMsg = ref("")

const editName = ref("")
const editBio = ref("")
const editImage = ref(null)
const imagePreview = ref(null)

watch(() => props.show, (newVal) => {
  if (newVal) {
    editName.value = props.user?.name ?? ""
    editBio.value = props.user?.bio ?? ""
    editImage.value = null
    imagePreview.value = props.imageUrl ?? null
    errorMsg.value = ""
  }
})

function onImageChange(e) {
  const file = e.target.files[0]
  if (!file) return

  editImage.value = file
  imagePreview.value = URL.createObjectURL(file)
}

async function saveProfile() {
  if (!editName.value.trim()) return

  saving.value = true
  errorMsg.value = ""

  const form = new FormData()
  form.append("_method", "PUT")
  form.append("name", editName.value)
  form.append("bio", editBio.value)

  if (editImage.value) {
    form.append("image", editImage.value)
  }

  try {
    const res = await axios.post(
      "http://backend.vm1.test/api/me",
      form,
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    )

    const updatedUser = res.data.user || res.data

    emit("save", {
      user: updatedUser,
      imageUrl: updatedUser?.image
        ? `http://backend.vm1.test/api/avatar/${updatedUser.image.split("/").pop()}`
        : null,
    })
  } catch (err) {
    errorMsg.value =
      err.response?.data?.message ?? "Failed to update profile."
  } finally {
    saving.value = false
  }
}

function closeModal() {
  emit("close")
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div
      class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 w-full max-w-md space-y-4"
    >
      <h3 class="text-xl font-bold">Edit Profile</h3>

      <div class="flex justify-center">
        <img
          v-if="imagePreview"
          :src="imagePreview"
          class="w-24 h-24 rounded-full object-cover"
        />
      </div>

      <input
        ref="fileInput"
        type="file"
        class="hidden"
        accept="image/*"
        @change="onImageChange"
      />

      <div
        @click="$refs.fileInput.click()"
        class="cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
      >
        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
          Click to upload a profile picture
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
          PNG or JPG up to 5MB
        </p>
      </div>

      <input
        v-model="editName"
        placeholder="Name"
        class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700"
      />

      <textarea
        v-model="editBio"
        placeholder="Bio"
        class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700"
      ></textarea>

      <p v-if="errorMsg" class="text-red-500 text-sm">
        {{ errorMsg }}
      </p>

      <div class="flex justify-end gap-2">
        <button @click="closeModal">Cancel</button>

        <button
          @click="saveProfile"
          :disabled="saving || !editName.trim()"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold disabled:opacity-50"
        >
          Save
        </button>
      </div>
    </div>
  </div>
</template>
