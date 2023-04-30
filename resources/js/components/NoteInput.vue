<template>
  <div class="mb-4 flex" :class="fullWidth ? 'w-full' : 'w-3/5'">
    <div v-if="trixEnabled">
      <Trix
        ref="trixEditor"
        @keydown.stop
        @change="val => $emit('update:modelValue', val)"
        :value="modelValue"
        :placeholder="placeholder"
        class="trix-content w-full form-control form-input form-input-bordered py-3 h-auto"
      />
    </div>

    <textarea
      v-else
      rows="3"
      :placeholder="placeholder"
      class="form-control w-full form-input form-input-bordered py-3 h-auto"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @keydown.enter="onEnter"
    />
  </div>
  <div class="flex w-full">
    <DefaultButton
      class="o1-inline-flex o1-items-center o1-relative o1-ml-auto o1-whitespace-nowrap"
      @click="$emit('onSubmit')"
      type="button"
      :disabled="loading || !modelValue"
    >
      {{ __('notesField.addNote') }}
    </DefaultButton>
  </div>
  <hr class="mt-3 mb-3">
</template>

<script>
export default {
  props: ['placeholder', 'modelValue', 'loading', 'trixEnabled', 'fullWidth'],
  methods: {
    onEnter(e) {
      if (e.shiftKey) return true;

      e.preventDefault();
      e.stopPropagation();
      this.$emit('onSubmit');
      return true;
    },
  },

  watch: {
    modelValue(newValue, oldValue) {
      if (this.trixEnabled && this.$refs.trixEditor) {
        if (!newValue && !!oldValue) this.$refs.trixEditor.$refs.theEditor.editor.loadHTML('');
      }
    },
  },
};
</script>
