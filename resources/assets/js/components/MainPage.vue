<template>
    <div>
        <h2 class="mt-4">Main page for Pickture</h2>
        <div class="mt-5">
            <button class="btn btn-primary text-white" id="buttonTest">Test</button>
            <button v-on:click="testing">testing</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'mainPage',
        methods: {
            testing() {
                $('#buttonTest').hide(500);    
            }
        }
    }
</script>