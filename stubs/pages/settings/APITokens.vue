<script setup lang="ts">
import CreateApiTokenForm from "@/components/CreateApiTokenForm.vue";
import HeadingSmall from "@/components/HeadingSmall.vue";
import ManageApiTokens from "@/components/ManageApiTokens.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import SettingsLayout from "@/layouts/settings/Layout.vue";
import { type BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: "API Tokens",
    href: "/settings/api-tokens",
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
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="API Tokens" />
    <SettingsLayout>
      <div class="space-y-6">
        <HeadingSmall title="API Tokens" description="Manage your API tokens" />
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
    </SettingsLayout>
  </AppLayout>
</template>
