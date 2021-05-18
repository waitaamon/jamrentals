<template>
    <div>
        <Modal v-model="showModal" modalClass="max-width: 700px" title="Payment Details">
            <div class="py-3">
                {{payment }}
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: 'payment-show-modal',
    data() {
        return {
            showModal: false,
            payment: null
        }
    }
}
</script>