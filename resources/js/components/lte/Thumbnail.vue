<template lang="html">
    <div class="thumbnail">
        <img :src="img" :alt="name">
        <div class="caption">
            <h4>{{ name }}<code style="color: blue;" class="pull-right">{{ price }}</code></h4>
            <p>
                <a href="#" class="btn btn-primary btn-xs" role="button">Comprar</a>
                <a href="#" class="btn btn-default btn-xs" role="button">Detalles</a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['name', 'img', 'price'],
}
</script>
