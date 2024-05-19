<script setup lang="ts">
import { object, string, type InferType } from 'yup'
import type { FormSubmitEvent } from '#ui/types'

const schema = object({
  username: string()
    .min(4, 'Must be at least 4 characters')
    .required('Required'),
  password: string()
    .min(8, 'Must be at least 8 characters')
    .required('Required')
})

type Schema = InferType<typeof schema>

const state = reactive({
  username: 'user',
  password: 'password'
})

async function onSubmit (event: FormSubmitEvent<Schema>) {
  // Do something with event.data
  const { data } = await useFetch<{token: string} | null>('http://localhost:8000/api/login_check', {
    method: 'post',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(state)
  })
  console.log(data.value?.token)
  if (data.value) {
    const { data: test } = await useFetch<{token: string} | null>('http://localhost:8000/api/test', {
      headers: {
        'Authorization': `Bearer ${data.value?.token}`
      },
    })
    console.log(test.value)
  }
}
</script>

<template>
  <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">
    <UFormGroup label="Username" name="username">
      <UInput v-model="state.username" />
    </UFormGroup>

    <UFormGroup label="Password" name="password">
      <UInput v-model="state.password" type="password" />
    </UFormGroup>

    <UButton type="submit">
      Submit
    </UButton>
  </UForm>
</template>