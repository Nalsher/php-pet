

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet-project</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        html, body {
            background-image: url("BG.png");
            background-size: cover;       
            background-repeat: no-repeat; 
            background-position: center;   
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #app {
            width: 100%;
            height: 100%;
        }
        .block > span {
            display: block;
        }
     </style>
</head>
<body>
<div id="app">
    <div class="flex justify-between items-center h-1/10 w-full">
        <div class="flex justify-center items-center w-1/6">
            <span class="text-3xl">F*ckBook</span>
        </div>
        <div class="flex justify-center items-center w-1/6 h-full">
            <button @click="createQuote" class="cursor-pointer bg-gray-600 border rounded border-gray-600 text-gray-00 w-full h-1/2">New Quote</button>
        </div> 
        <div class="flex justify-between items-center w-1/8 h-full">
            <button @click="redirectToLogin" class="cursor-pointer bg-gray-600 border rounded border-gray-600 text-gray-00 w-1/2 h-1/2">Sign in!</button>
        </div>
    </div>
    <div class="body flex h-9/10 w-full px-[15vw]">
        <div class="grid grid-cols-3 w-full">
            <div v-for="item in quotes" class="bg-white flex justify-center items-center border border-black">
                <div class="flex flex-col gap-12 w-1/3 h-1/3">
                    <div class="flex justify-center items-center w-full h-1/3">
                        <img :src=item.img_url>
                    </div>
                    <div class="flex justify-center items-center w-full h-1/3">                    
                        <span>{{item.text}}</span>
                    </div>                     
                    <div class="flex justify-center items-center w-full h-1/3">                       
                        <span>{{item.username}}</span>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const { createApp } = Vue;


createApp({
    methods: {
      redirectToLogin() {
          window.location.href = "http://localhost:8000/login.html"
      },
      createQuote() {
          window.location.href = "http://localhost:8000/createQuotes.php"
      },
    },
    data() {
        return {
            quotes: []
        }
    },
    mounted() {
        fetch('getQuotes.php')
            .then(res => res.json()
            .then(data => {
                this.quotes = data;
        })
            );
    }
}).mount('#app');
</script>
</body>
</html>
