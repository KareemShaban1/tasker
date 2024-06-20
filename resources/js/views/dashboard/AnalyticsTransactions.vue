<script setup>
import { ref, watch, onMounted } from 'vue'
import useDashboard from '@/services/Modules/DashboardService'

const { data, getData } = useDashboard()
const statistics = ref([])

// Function to update statistics based on data
const updateStatistics = () => {
  statistics.value = [
    {
      title: 'Categories',
      stats: data.value?.categories ?? 'N/A',
     
      icon: 'ri-pie-chart-2-line',
      color: 'success',
    },
    {
      title: 'Clients',
      stats: data.value?.clients ?? 'N/A',
       icon: 'ri-group-line',
      color: 'primary',
    },
    {
      title: 'Tasks',
      stats: data.value?.tasks ?? 'N/A',
      icon: 'ri-task-line',
      color: 'warning',
    },
    {
      title: 'Offers',
      stats: data.value?.offers ?? 'N/A',
      icon: 'ri-money-dollar-circle-line',
      color: 'info',
    },
  ]
}

// Watch for changes in the data and update statistics
watch(data, updateStatistics)

// Fetch data on component mount
onMounted(() => {
  getData()
})
</script>

<template>
  <VCard title="Statistics">

    <template #append>
      <IconBtn class="mt-n5">
        <VIcon
          color="high-emphasis"
          icon="ri-more-2-line"
        />
      </IconBtn>
    </template>

    <VCardText class="pt-5">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="12"
          sm="6"
          md="3"
        >
          <div class="d-flex align-center gap-x-3">
            <VAvatar
              :color="item.color"
              rounded
              size="40"
              class="elevation-2"
            >
              <VIcon
                size="24"
                :icon="item.icon"
              />
            </VAvatar>

            <div class="d-flex flex-column">
              <div class="text-body-1">
                {{ item.title }}
              </div>
              <h5 class="text-h5">
                {{ item.stats }}
              </h5>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
