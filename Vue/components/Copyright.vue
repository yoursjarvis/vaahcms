<template>
    <div>

        <p v-if="assets">
            &copy; {{root.assets.server.current_year}}.
            <a :href="assets.vaahcms.website" target="_blank">{{root.assets.vaahcms.name}}</a>
            v{{root.assets.versions.vaahcms_version}}
            | <a :href="assets.vaahcms.docs" target="_blank">Documentation</a>
        </p>

        <p class="has-text-centered" v-if="assets">
            Laravel v{{root.assets.versions.laravel_version}}
            | PHP v{{root.assets.versions.php_version}}
        </p>
    </div>
</template>

<script>

    export default {
        computed:{
            root() {return this.$store.getters['root/state']},
            assets() {return this.$store.getters['root/state'].assets},
        },
    }

</script>
