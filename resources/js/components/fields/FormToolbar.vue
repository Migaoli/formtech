<template>
    <div class="flex justify-end mb-8" v-if="isDirty">
        <button class="btn btn-tertiary btn-default mr-4"
                type="button"
                :disabled="saving"
                v-on="resetActions">
            Cancel
        </button>
        <button class="btn btn-primary btn-blue"
                type="submit"
                :disabled="saving"
                v-on="submitActions">
            <span v-if="saving">Saving...</span>
            <span v-else>Save</span>
        </button>
    </div>
</template>

<script>
    export default {
        name: 'form-toolbar',

        props: {
            isDirty: {
                type: Boolean,
                required: true,
            },

            saving: {
                type: Boolean,
                required: true,
            },

            resetActions: {
                type: Object,
                required: true,
            },

            submitActions: {
                type: Object,
                required: true,
            }
        }
    }
</script>