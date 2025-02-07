<x-modal name="confirm-delete" maxWidth="sm" focusable>
  <div x-data="{
      actionUrl: null,
      init() {
          window.addEventListener('set-delete-action', (event) => {
              this.actionUrl = event.detail;
          });
      }
  }" x-init="init()">
    <form method="post" :action="actionUrl" class="p-6" x-show="actionUrl">
      @csrf
      @method('delete')

      <h2 class="text-lg font-medium text-gray-900">
        {{ __('Are you sure you want to delete data?') }}
      </h2>

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button type="submit" class="ms-3">
          {{ __('Delete') }}
        </x-danger-button>
      </div>
    </form>
</x-modal>