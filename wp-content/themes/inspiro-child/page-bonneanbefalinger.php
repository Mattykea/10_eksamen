<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.1
 */

get_header(); 
?>
  <section class="section1">
    <div class="col1">
      <h2>Filterkaffe</h2>
      <img class="filterbil" src="" alt="">
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sunt odio neque officiis vitae corrupti nemo delectus eligendi esse illum incidunt maxime nihil sit sint, nostrum consequatur? Iusto dolor corporis autem libero odit consequatur, eligendi iure at consectetur accusamus, omnis ullam ea? Eligendi soluta praesentium ea corrupti labore quos. Ullam, error?</p>
    </div>

    <div class="col2">
      <h2>Espresso</h2>
      <img class="espressobil" src="" alt="">
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus dolor impedit aliquid et illo doloribus alias, exercitationem voluptatum esse assumenda architecto in deleniti quis autem aut, illum non. Cum alias reiciendis nobis hic eaque excepturi blanditiis, corporis unde fugiat repudiandae dicta esse voluptate illo quae voluptatum, quaerat dolores dolorem libero?</p>
    </div>
  </section>
   <template>
      <article class="styleanbefalinger">
        <img src="" alt="" />
        <h2></h2>
        <p class="tekst"></p>
      </article>
    </template>

	<div id="primary" class="content-area">
                
 
    
		<main id="main" class="site-main">	
      <nav id="filtrering">
      </nav>
      <h1></h1>
            <section class="anbefalingcontainer"></section>
    </main><!-- #main -->

<script>
    "use strict";
       console.log("nu starter script");
      const container = document.querySelector(".anbefalingcontainer");
      const temp = document.querySelector("template");

      const url = "https://mathildese.dk/kea/10_eksamen/wp-json/wp/v2/anbefaling?per_page=100";
      const catUrl = "https://mathildese.dk/kea/10_eksamen/wp-json/wp/v2/categories";

      let data = [];
      let categories; 
      let filterAnbefaling = "alle";

      let filter = "alle";
      const filterknapper = document.querySelectorAll("button");
      let anbefalinger;
    

      document.addEventListener("DOMContentLoaded", start);

      function start() {
        filterknapper.forEach((knap) => {
          knap.addEventListener("click", setFilter);
        });

        hentData();
      }

      function setFilter() {
        filter = this.dataset.anbefaling;
        document.querySelector("h1").textContent = this.textContent;
        vis();
      }

      async function hentData() {
        console.log("hentData");
        const respons = await fetch(url);
        const catData = await fetch(catUrl);
        anbefalinger = await respons.json();
        categories = await catData.json();
        console.log(categories);
        vis();
        opretKnapper();
      }

      function opretKnapper() {

        categories.forEach(cat =>{
          document.querySelector("#filtrering").innerHTML += `<button class="filter" data-anbefaling="${cat.id}">${cat.name}</button>`
        })

        addEventListenersToButtons();
      }

      function addEventListenersToButtons(){
          document.querySelectorAll("#filtrering button").forEach(elm => {
            elm.addEventListener("click", filtrering);
          })

      };

      function filtrering() {
           filterAnbefaling = this.dataset.anbefaling;
           console.log(filterAnbefaling);

           vis();
      }

      
      function vis() {
        console.log("vis");
        console.log(anbefalinger);
        container.textContent = "";

        anbefalinger.forEach((anbefaling) => {
          const klon = temp.cloneNode(true).content;

          //FILTRERING
          if (filterAnbefaling == "alle" || anbefaling.categories.includes(parseInt(filterAnbefaling))) {
            klon.querySelector(".tekst").textContent = anbefaling.tekst;
            klon.querySelector("h2").textContent = anbefaling.title.rendered;
            klon.querySelector("img").src = anbefaling.billede.guid;
            console.log("Hej " + anbefaling.link)
            klon.querySelector("article").addEventListener("click", () => {location.href = anbefaling.link; })
            container.appendChild(klon);
               }
          })
      }

     
       
    </script>

    	</div><!-- #primary -->


<?php
get_footer();
