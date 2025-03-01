<script setup lang="ts">
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

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

const isTokenBeingEdited = ref(false);

const apiTokenBeingEdited = ref<Token | null>(null);

const isTokenBeingDeleted = ref(false);

const apiTokenBeingDeleted = ref<Token | null>(null);

const deleteApiTokenForm = useForm({});

const updateApiTokenForm = useForm({
  permissions: [] as string[],
});

const editApiToken = (token: Token) => {
  isTokenBeingEdited.value = true;
  updateApiTokenForm.permissions = token.abilities;
  apiTokenBeingEdited.value = token;
};

const updateApiToken = () => {
  if (!apiTokenBeingEdited.value) return;
  updateApiTokenForm.put(
    route("api-tokens.update", { token: apiTokenBeingEdited.value }),
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (
        (apiTokenBeingEdited.value = null), (isTokenBeingEdited.value = false)
      ),
    }
  );
};

const confirmApiTokenDeletion = (token: Token) => {
  isTokenBeingDeleted.value = true;
  apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
  if (!apiTokenBeingDeleted.value) return;
  deleteApiTokenForm.delete(
    route("api-tokens.destroy", { token: apiTokenBeingDeleted.value }),
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (
        (apiTokenBeingDeleted.value = null), (isTokenBeingDeleted.value = false)
      ),
    }
  );
};
</script>

<template>
  <Card v-if="tokens.length > 0" class="w-full">
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

          <div class="flex gap-4 items-center ms-2">
            <div class="text-sm text-gray-400">
              Last used |
              {{
                token.last_used_at
                  ? new Date(token.last_used_at).toLocaleString()
                  : "Never"
              }}
            </div>
            <Button
              v-if="availablePermissions.length > 0"
              @click="editApiToken(token)"
            >
              Edit
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

  <Dialog v-model:open="isTokenBeingEdited">
    <DialogContent class="max-w-xl">
      <DialogHeader class="space-y-3">
        <DialogTitle>API Token Permissions</DialogTitle>
        <DialogDescription
          >Manage the permissions for this API token.</DialogDescription
        >
      </DialogHeader>
      <div class="mt-4 text-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div v-for="permission in availablePermissions" :key="permission">
            <Label class="flex items-center">
              <Checkbox
                :id="permission"
                :checked="updateApiTokenForm.permissions.includes(permission)"
                @update:checked="
                  (checked) => {
                    if (checked) {
                      updateApiTokenForm.permissions.push(permission);
                    } else {
                      updateApiTokenForm.permissions =
                        updateApiTokenForm.permissions.filter(
                          (p) => p !== permission
                        );
                    }
                  }
                "
                :tabindex="4"
              />
              <span class="text-sm ms-2">{{ permission }}</span>
            </Label>
          </div>
        </div>
      </div>
      <DialogFooter>
        <DialogClose as-child>
          <Button variant="secondary" @click="isTokenBeingEdited = false">
            Close
          </Button>
        </DialogClose>
        <form @submit.prevent="updateApiToken">
          <Button
            type="submit"
            class="ms-3"
            :disabled="updateApiTokenForm.processing"
            @click="updateApiToken"
          >
            Save
          </Button>
        </form>
      </DialogFooter>
    </DialogContent>
  </Dialog>

  <Dialog v-model:open="isTokenBeingDeleted">
    <DialogContent class="max-w-xl">
      <DialogHeader class="space-y-3">
        <DialogTitle>Delete API Token</DialogTitle>
        <DialogDescription
          >Are you sure you would like to delete this API
          token?</DialogDescription
        >
      </DialogHeader>
      <DialogFooter>
        <DialogClose as-child>
          <Button variant="secondary" @click="apiTokenBeingDeleted = null"
            >Close</Button
          >
        </DialogClose>
        <form @submit.prevent="deleteApiToken">
          <Button
            variant="destructive"
            type="submit"
            class="ms-3"
            :disabled="deleteApiTokenForm.processing"
            @click="deleteApiToken"
          >
            Delete
          </Button>
        </form>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
