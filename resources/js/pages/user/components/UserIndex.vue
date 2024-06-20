<template>
  <Header
  title="User"
  create-component
  create-title="Create new user"
  store="User"
  :query="query"
  :selected-ids="selectedIds"
  @clear-selected="updateSelectedIds"
/>   
<div>
    <VCard>
      <VCardText>
        <VTable>
          <thead>
            <tr>
              <th class="text-capitalize"> 
                #
              </th>
              <th class="text-capitalize">
                Name
              </th>
              <th class="text-capitalize">
                Email
              </th>
              <th class="text-capitalize">
                created at
              </th>
              <th class="text-capitalize text-center">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user,index) in users"
              :key="user.id"
            >
              <UserDetails
                :index="(paginatedData.pagination.current_page - 1) * paginatedData.pagination.per_page + index + 1"
                :user="user"
                :query="query"
              />
            </tr>
            <div
              v-if="isLoading"
              class="loading-page"
            >
              <VProgressCircular
                :per_page="50"
                color="primary"
                indeterminate
              />
            </div>
          </tbody>
        </VTable>
      </VCardText>
    </VCard>

    <PaginationComponent :query="query" store="User" />
  </div>
</template>

<script>
import UserDetails from "@/pages/user/components/list/UserDetails.vue"
import PaginationComponent from '@/components/PaginationComponent.vue'
import Header from "@/components/Header.vue"
import { computed } from "vue"
import { useStore } from 'vuex'


export default {
  name: 'UserIndex',
  components: { UserDetails, Header, PaginationComponent },

  setup() {
    const store = useStore()

    const users = computed(() => store.getters['User/usersList'])
    const paginatedData = computed(() => store.getters['User/paginatedData'])
    const isLoading = computed(() => store.getters['User/isLoading'])

    const fetchAll = () => {
      store.dispatch('User/fetchAll', query)
    }

    onMounted(() => {
      fetchAll()
    })

    const query = reactive({
      page: 1,
      per_page: 10,
      name: '',
      paginate: true,
      full_data: true,
      with_trashed: true,
    })

    return {
      query,
      users,
      paginatedData,
      isLoading,
    }
  },
}
</script>
