<template>
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
    data() {
        return {
            colors: {
                info: '#00c0ef',
                primary: '#3c8dbc',
                default: '#d2d6de',
                warning: '#f39c12',
                success: '#00a65a',
                danger: '#f56954',
            }
        }
    },
    computed: {
        modalColor() {
            if (this.color) {
                if (this.color.substr(0, 1) == '#') {
                    return this.color
                }            
                return this.colors[this.color]
            }

            return '#3c8dbc'
        }
    },
}
</script>
