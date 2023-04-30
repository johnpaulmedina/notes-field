<template>
    <div class="md:flex items-center mb-3 o1-bg-slate-100 dark:o1-bg-slate-800 o1-rounded-md o1-border o1-border-gray-200 dark:o1-border-gray-700 o1-px-3 o1-py-3 o1-flex o1-mb-2 o1-mt-2" :class="{ 'w-full': fullWidth, 'w-3/5': !fullWidth }">
        <div class="flex flex-auto items-center">
          <!-- <div
            class="o1-w-3/5 o1-bg-slate-100 dark:o1-bg-slate-800 o1-rounded-md o1-border o1-border-gray-200 dark:o1-border-gray-700 o1-px-3 o1-py-3 o1-flex o1-mb-2 o1-mt-2"
            
          > -->
            <div class="o1-rounded-lg o1-w-12 o1-h-12 o1-mr-3 o1-overflow-hidden o1-text-center" style="flex-shrink: 0">
              <!-- Image -->
              <div
                v-if="note.system"
                class="o1-w-12 o1-h-12 o1-text-sm o1-font-bold o1-bg-gray-50 o1-text-gray-700 dark:o1-text-gray-400"
                style="line-height: 3rem"
              >
                {{ __('notesField.systemUserAbbreviation') }}
              </div>
              <img class="o1-w-12 o1-h-12" v-else-if="note.created_by_avatar_url" :src="note.created_by_avatar_url" alt="" />
              <div
                v-else
                class="o1-w-12 o1-h-12 o1-text-sm o1-font-bold o1-bg-gray-50 o1-text-gray-700 dark:o1-text-gray-400"
                style="line-height: 3rem"
              >{{ !!note.created_by_name ? (note.created_by_name || '').substr(0, 3).toUpperCase() : '??' }}
              </div>
            </div>

            <div>
              <!-- Title area -->
              <div class="o1-mb-2">
                <span class="o1-font-bold o1-text-base o1-text-gray-700 o1-mr-2 dark:o1-text-gray-400">
                  {{ note.created_by_name ? note.created_by_name : __('notesField.systemUserName') }}
                </span>

                <span class="o1-text-xs o1-text-gray-700 o1-mr-2 dark:o1-text-gray-400">
                  {{ formattedCreatedAtDate }}{{ note.system ? `[${__('notesField.systemUserName')}]` : '' }} 
                </span>

                <!-- <span
                  v-if="!note.system && note.can_delete"
                  class="o1-text-xs hover:o1-underline o1-cursor-pointer"
                  style="color: #e74c3c"
                  @click="$emit('onDeleteRequested', note)"
                >[{{ __('notesField.delete') }}]
                </span> -->

              </div>

              <!-- Content -->
              <p v-html="note.text" class="o1-whitespace-pre-wrap o1-text-gray-800 dark:o1-text-gray-400 mt-3 mb-3"></p>
            </div>
        </div>
        <div class="ml-auto flex items-center">
          <button
            v-if="
              !note.system && note.can_delete
            "
            v-tooltip.click="__('notesField.delete')"
            :aria-label="__('notesField.delete')"
            :disabled="!note.can_delete"
            class="toolbar-button hover:text-primary-500 px-2 disabled:opacity-50 disabled:pointer-events-none o1-bg-white o1-border-gray-200"
            @click="$emit('onDeleteRequested', note)"
          >
            <Icon type="trash" />
          </button>
        </div>
    </div>
</template>

<script>
import { format } from 'date-fns';

export default {
  props: ['note', 'dateFormat', 'fullWidth'],
  computed: {
    formattedCreatedAtDate() {
      return format(new Date(this.note.created_at), this.dateFormat);
    },
  },
};
</script>
