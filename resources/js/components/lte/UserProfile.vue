<template lang="html">
    <div :class="'box box-' + color">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" :src="img" alt="Imagen de perfil">

            <h3 class="profile-username text-center">{{ name }}</h3>

            <p class="text-muted text-center">{{ job }}</p>

            <ul class="list-group list-group-unbordered">
                <slot></slot>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['color', 'img', 'name', 'job']
}
</script>
