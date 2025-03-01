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
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { type SharedData } from "@/types";
import { useForm, usePage } from "@inertiajs/vue3";
import { Copy } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps<{
  availablePermissions: string[];
  defaultPermissions: string[];
}>();

const form = useForm({
  name: "",
  permissions: props.defaultPermissions,
});

const page = usePage<SharedData>();

const isTokenDialogOpen = ref(false);

const recentlyCopied = ref(false);

const createApiToken = () => {
  form.post(route("api-tokens.store"), {
    preserveScroll: true,
    onSuccess: () => {
      openDisplayTokenDialog();
      form.reset();
    },
  });
};

const openDisplayTokenDialog = () => {
  isTokenDialogOpen.value = true;
};

const closeModal = () => {
  isTokenDialogOpen.value = false;
};

const copyToken = () => {
  recentlyCopied.value = true;

  navigator.clipboard.writeText(page.props.flash.api_token as string);

  setTimeout(() => {
    recentlyCopied.value = false;
  }, 2000);
};
</script>

<template>
  <Card class="w-full">
    <CardHeader>
      <CardTitle>Create API Token</CardTitle>
    </CardHeader>
    <CardContent>
      <CardDescription
        >API tokens allow third-party services to authenticate with our
        application on your behalf.</CardDescription
      >
      <form @submit.prevent="createApiToken" class="mt-6 space-y-6">
        <div>
          <Label for="name" value="Name" />
          <Input
            id="name"
            type="text"
            required
            autofocus
            :tabindex="1"
            autocomplete="name"
            v-model="form.name"
            placeholder="API Token Name"
          />
          <InputError :message="form.errors.name" />
        </div>

        <div>
          <!-- Token Permissions -->
          <div v-if="availablePermissions.length > 0" class="col-span-6">
            <Label for="permissions" value="Permissions" />
            <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
              <div v-for="permission in availablePermissions" :key="permission">
                <Label :for="permission" class="flex items-center space-x-3">
                  <Checkbox
                    :id="permission"
                    :checked="form.permissions.includes(permission)"
                    @update:checked="
                      (checked) => {
                        if (checked) {
                          form.permissions.push(permission);
                        } else {
                          form.permissions = form.permissions.filter(
                            (p) => p !== permission
                          );
                        }
                      }
                    "
                    :tabindex="4"
                  />
                  <span>{{ permission }}</span>
                </Label>
              </div>
            </div>
          </div>
        </div>
        <Button
          type="submit"
          class="mt-4"
          :tabindex="4"
          :disabled="form.processing"
        >
          Create
        </Button>
      </form>
    </CardContent>
  </Card>

  <Dialog v-model:open="isTokenDialogOpen">
    <DialogContent class="max-w-xl">
      <DialogHeader class="space-y-3">
        <DialogTitle>API Token</DialogTitle>
        <DialogDescription>
          Please copy your new API token. For your security, it won't be shown
          again.
        </DialogDescription>
      </DialogHeader>

      <div
        v-if="$page.props.flash.api_token"
        class="flex justify-between items-center px-4 py-2 mt-4 font-mono text-sm text-gray-500 break-all bg-gray-100 rounded border border-gray-200 dark:border-gray-400 dark:bg-background dark:text-gray-400"
      >
        {{ $page.props.flash.api_token }}
        <button
          @click="copyToken"
          type="button"
          class="flex items-center px-3 py-1 text-xs bg-gray-300 rounded cursor-pointer hover:opacity-75"
        >
          <Copy class="w-4 h-4" />
        </button>
      </div>
      <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
      >
        <p
          v-if="recentlyCopied"
          class="flex justify-end mt-2 mr-2 text-xs text-gray-600 dark:text-gray-400"
        >
          Copied to clipboard!
        </p>
      </Transition>

      <DialogFooter>
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
