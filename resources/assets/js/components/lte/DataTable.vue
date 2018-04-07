<template lang="html">
    <div class="table-responsive">
        <table :id="'example' + example" class="table table-bordered table-striped">
            <thead>
                <slot name="header"></slot>
            </thead>

            <tbody>
                <slot name="body"></slot>
            </tbody>

            <tfoot>
                <slot name="footer"></slot>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props: ['example']
}
</script>
