<script setup lang="ts">
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps<{
  tokens: Array;
  availablePermissions: Array;
  defaultPermissions: Array;
}>();

const managingPermissionsFor = ref(null);

const apiTokenBeingDeleted = ref(null);

const deleteApiTokenForm = useForm({});

const updateApiTokenForm = useForm({
  permissions: [],
});

const manageApiTokenPermissions = (token) => {
  console.log(token);
  updateApiTokenForm.permissions = token.abilities;
  managingPermissionsFor.value = token;
};

const updateApiToken = () => {
  updateApiTokenForm.put(
    route("api-tokens.update", managingPermissionsFor.value),
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (managingPermissionsFor.value = null),
    }
  );
};

const confirmApiTokenDeletion = (token) => {
  apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
  deleteApiTokenForm.delete(
    route("api-tokens.destroy", apiTokenBeingDeleted.value),
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (apiTokenBeingDeleted.value = null),
    }
  );
};
</script>

<template>
  <Card class="w-full">
    <CardHeader>
      <CardTitle>Manage API Tokens</CardTitle>
    </CardHeader>
    <CardContent>
      <CardDescription
        >You may delete any of your existing tokens if they are no longer
        needed.</CardDescription
      >
      <div class="mt-6 space-y-6">
        <div
          v-for="token in tokens"
          :key="token.id"
          class="flex justify-between items-center"
        >
          <div class="break-all">
            {{ token.name }}
          </div>

          <div class="flex gap-2 items-center ms-2">
            <div v-if="token.last_used_ago" class="text-sm text-gray-400">
              Last used {{ token.last_used_ago }}
            </div>

            <Button
              v-if="availablePermissions.length > 0"
              @click="manageApiTokenPermissions(token)"
            >
              Permissions
            </Button>

            <Button
              variant="destructive"
              @click="confirmApiTokenDeletion(token)"
              >Delete</Button
            >
          </div>
        </div>
      </div>
    </CardContent>
  </Card>

  <!-- API Token Permissions Modal -->
  <!---<Modal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <div class="p-6">
                <div class="text-lg font-medium text-gray-900">API Token Permissions</div>

                <div class="mt-4 text-sm text-gray-600">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                                <span class="text-sm text-gray-600 ms-2">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <Button variant="secondary" @click="managingPermissionsFor = null"> Cancel </Button>

                    <Button
                        class="ms-3"
                        :class="{ 'opacity-25': updateApiTokenForm.processing }"
                        :disabled="updateApiTokenForm.processing"
                        @click="updateApiToken"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>-->

  <!-- Delete Token Confirmation Modal -->
  <!--<Modal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
            <div class="p-6">
                <div class="text-lg font-medium text-gray-900">Delete API Token</div>

                <div class="mt-4 text-sm text-gray-600">Are you sure you would like to delete this API token?</div>

                <div class="flex justify-end mt-6">
                    <Button variant="secondary" @click="apiTokenBeingDeleted = null"> Cancel </Button>

                    <Button variant="destructive" class="ms-3" :disabled="deleteApiTokenForm.processing" @click="deleteApiToken">
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>-->
</template>
