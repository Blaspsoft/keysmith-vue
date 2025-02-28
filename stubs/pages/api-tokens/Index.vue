<script setup lang="ts">
import CreateApiTokenForm from "@/components/CreateApiTokenForm.vue";
import Heading from "@/components/Heading.vue";
import ManageApiTokens from "@/components/ManageApiTokens.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: "API Tokens",
    href: "/api-tokens",
  },
];

interface Token {
  id: number;
  tokenable_type: string;
  tokenable_id: number;
  name: string;
  abilities: string[];
  last_used_at: string;
}

defineProps<{
  tokens: Token[];
  availablePermissions: string[];
  defaultPermissions: string[];
}>();
</script>

<template>
  <Head title="API Tokens" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 py-6 space-y-6">
      <Heading title="API Tokens" description="Manage your API tokens" />
      <CreateApiTokenForm
        :available-permissions="availablePermissions"
        :default-permissions="defaultPermissions"
      />
      <ManageApiTokens
        :tokens="tokens"
        :available-permissions="availablePermissions"
        :default-permissions="defaultPermissions"
      />
    </div>
  </AppLayout>
</template>
