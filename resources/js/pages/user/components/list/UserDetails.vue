<template>
  <td>
    {{ index }}
  </td>
  <td >
    {{ user.name }}
  </td>
  <td>
    {{ user.email }}
  </td>
  <td class="text-capitalize">
    <span class="date">{{ humanReadableDate(user.created_at).date }}</span>
    <br>
    <span class="time">{{ humanReadableDate(user.created_at).time }}</span>
  </td>

  <td class="d-flex gap-1 justify-center align-center">
    <VBtn
      v-if="user.deleted_at == null"
      color="warning"
      size="small"
      class="me-1"
      title="Edit user"
      @click="editUserModel(user)"
    >
      <VIcon icon="ri-edit-box-line" />
    </VBtn>
    <VBtn
      v-if="user.deleted_at == null"
      size="small"
      class="me-1 bg-error text-capitalize"
      title="Delete user"
      color="error"
      @click="deleteUserModal(user.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>

    <VBtn
      v-if="user.deleted_at !== null"
      size="small"
      rounded="lg"
      color="warning"
      class="me-1 text-capitalize"
      title="restore user"
      @click="restoreUserModal(user.id)"
    >
      <VIcon icon="ri-arrow-turn-forward-line" />
    </VBtn>
    <VBtn
      v-if="user.deleted_at !== null"
      size="small"
      rounded="lg"
      color="primary"
      class="me-1 text-capitalize"
      title="Force delete user"
      @click="forceDeleteUserModal(user.id)"
    >
      <VIcon icon="ri-delete-bin-line" />
    </VBtn>
  </td>
</template>

<script>
import useHandler from "@/services/handler"
import Swal from "sweetalert2"
import { mapActions, mapMutations } from "vuex"


const { getQueryParamsFromUrl, humanReadableDate } = useHandler()

export default {
  name: "UserDetail",
  props: {
    user: {
      type: Object,
      required: true,
    },
    index: {
      type: Number,
      required: true,
      default: 0,
    },
  },
  setup() {
    const select = ref([])

    return {
      select,
      humanReadableDate,
    }
  },

  methods: {
    ...mapMutations("User", ["setIsUpdating"]),

    ...mapActions('User', ['fetchAll', 'deleteUser', 'restoreUser', 'forceDeleteUser', 'editUser']),

    forceDeleteUserModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.forceDeleteUser(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    deleteUserModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteUser(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    restoreUserModal(id) {
      Swal.fire({
        title: 'Are you sure ?',
        showCancelButton: true,
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.restoreUser(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    BulkDeleteUserModal(id) {
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
      }).then(result => {
        if (result.isConfirmed) {
          this.deleteUser(id).then(() => {
            this.fetchAll(getQueryParamsFromUrl())
          })
        }
      })
    },

    editUserModel(user) {
      this.editUser(user.id)
    },
  },
}
</script>
