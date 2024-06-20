<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const headers = [
  { title: 'Name', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Phone', key: 'phone' },
  { title: 'Location', key: 'location' },
  { title: 'City', key: 'city' },
  { title: 'State', key: 'state' },
  { title: 'Country', key: 'country' },
  { title: 'Status', key: 'status' },
];

const userData = ref([]);

const resolveUserStatusVariant = (isActive) => {
  if (isActive) return 'success';
  return 'secondary';
};

onMounted(async () => {
  try {
    const response = await axios.get('/api/clients'); // Adjust the API endpoint as needed
    console.log('API Response:', response);

    if (Array.isArray(response.data)) {
      userData.value = response.data.map(user => ({
        ...user,
        city: user.city?.name || 'N/A',
        state: user.state?.name || 'N/A',
        country: user.country?.name || 'N/A',
        status: user.is_active ? 'Active' : 'Inactive',
      }));
    } else if (response.data.data && Array.isArray(response.data.data)) {
      userData.value = response.data.data.map(user => ({
        ...user,
        city: user.city?.name || 'N/A',
        state: user.state?.name || 'N/A',
        country: user.country?.name || 'N/A',
        status: user.is_active ? 'Active' : 'Inactive',
      }));
    } else {
      console.error('Unexpected response structure:', response.data);
    }
  } catch (error) {
    console.error('Error fetching user data:', error);
  }
});
</script>




<template>
  <VCard title="Clients">
    <VDataTable
      :headers="headers"
      :items="userData"
      item-value="id"
      class="text-no-wrap"
    >
      <!-- Name -->
      <template #item.name="{ item }">
        <div class="d-flex align-center gap-x-4">
          <div class="d-flex flex-column">
            <h6 class="text-h6 font-weight-medium user-list-name">
              {{ item.name }}
            </h6>
            <span class="text-sm text-medium-emphasis">{{ item.name }}</span>
          </div>
        </div>
      </template>

      <!-- Email -->
      <template #item.email="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.email }}</span>
      </template>
      
      <!-- Phone -->
      <template #item.phone="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.phone }}</span>
      </template>
      
      <!-- Location -->
      <template #item.location="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.location }}</span>
      </template>

      <!-- City -->
      <template #item.city="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.city }}</span>
      </template>
      
      <!-- State -->
      <template #item.state="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.state }}</span>
      </template>
      
      <!-- Country -->
      <template #item.country="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.country }}</span>
      </template>

      <!-- Status -->
      <template #item.status="{ item }">
        <VChip
          :color="resolveUserStatusVariant(item.is_active)"
          size="small"
          class="text-capitalize"
        >
          {{ item.status }}
        </VChip>
      </template>

      <template #bottom />
    </VDataTable>
  </VCard>
</template>
