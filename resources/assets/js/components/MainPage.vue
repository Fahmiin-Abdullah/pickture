<template>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100 br-10" :src="require('../../img/showcase_1.jpg')" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 br-10" :src="require('../../img/showcase_2.jpg')" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 br-10" :src="require('../../img/showcase_3.jpg')" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card br-10">
                <div class="card-body">
                    <h4 class="text-center">Who this site is for</h4>
                    <ul>
                        <li>Anyone looking to share their work with the rest of the world.</li>
                        <li>Anyone looking for that specific image you couldn't find on the net. You can browse through our stock photos or connect with one of our photographers and we'll arrange a purchase for you.</li>
                        <li>Anyone who appreciate good quality photos and doesn't mind hours of scrolling through them.</li>
                        <li>Do check out our <router-link to="/licence">terms of licenses</router-link> before uploading any photos onto the net. It can be a scary place at times...</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <router-link to="/discover/any" class="btn btn-success text-white btn-block"><i class="fa fa-search mr-3"></i>Discover</router-link>
                </div>
                <div class="col-6">
                    <router-link to="/categories/any" class="btn btn-dark text-white btn-block"><i class="fa fa-globe-americas mr-3"></i>Browse Categories</router-link>
                </div>
            </div>
            <h6 class="text-center mt-4">Pickture &copy; since 2018 | By The Cursive Developer</h6>
        </div>
    </div> 
</template>

<script>
    export default {
        name: 'mainPage'
    }
</script>

<style lang="scss">
    /*Main styles*/
    .container90 {
        width: 90%;
        margin: auto;
    }

    .br-10 {
        border-radius: 10px;
    }

    .hidden {
        display: none;
    }

    .carousel-item {
        img {
            height: 500px;
        }
    }
    
    @media only screen and (max-width: 600px) {
        .carousel-item {
            img { 
                height: 50vh !important;
            }
        }
    }
</style>