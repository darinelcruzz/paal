<template lang="html">
    <div class="modal fade" :id="id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" :style="'background: ' + modalColor + '; color: white'">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ title }}</h4>
                </div>

                <div class="modal-body">
                    <slot></slot>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'id', 'color'],
    computed: {
        modalColor() {
            return this.color == '' ? '#3c8dbc': this.color;
        }
    },
}
</script>
