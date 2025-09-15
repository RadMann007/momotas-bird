<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
})
</script>

<template>
  <Head title="Madagascar Bird Tours" />

  <div class="bg-slate-50 text-gray-800 font-sans antialiased">

    <!-- HEADER -->
    <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50 animate-fadeDown">
      <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <h1 class="text-3xl font-bold text-emerald-600 tracking-tight hover:scale-110 transition-transform duration-300">
          <Link href="/">🦜 Momotas Bird</Link>
        </h1>
        <nav class="hidden md:flex items-center gap-8">
          <a href="#species" class="nav-link">Espèces</a>
          <a href="#tours" class="nav-link">Itinéraires</a>
          <a href="#gallery" class="nav-link">Galerie</a>
          <a href="#contact" class="nav-link">Contact</a>
          <!-- <div v-if="canLogin" class="flex items-center gap-4 ml-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-emerald-600 font-semibold hover:underline">
              Tableau de bord
            </Link>
            <template v-else>
              <Link :href="route('login')" class="nav-link">Connexion</Link>
              <Link v-if="canRegister" :href="route('register')" class="btn-cta">
                Inscription
              </Link>
            </template>
          </div> -->
        </nav>
      </div>
    </header>

    <!-- HERO -->
    <main>
      <section class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
          <img src="/images/1.jpg" class="w-full h-full object-cover scale-105 animate-zoomInSlow" />
          <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <div class="relative z-10 px-6 max-w-4xl mx-auto">
          <h2 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight animate-fadeUp">
            Explorez l'avifaune unique de <span class="text-emerald-400">Madagascar</span>
          </h2>
          <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto animate-fadeUp delay-200">
            L'île sanctuaire d'espèces endémiques. Vivez une aventure ornithologique que vous n'oublierez jamais.
          </p>
          <a href="#tours" class="btn-cta animate-bounceSlow">
            Découvrir nos itinéraires
          </a>
        </div>
      </section>

      <!-- SPECIES -->
      <section id="species" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
          <h3 class="section-title">Espèces Emblématiques</h3>
          <p class="section-subtitle">Découvrez quelques-uns des trésors ailés que seule Madagascar peut offrir.</p>
          <div class="grid gap-8 md:grid-cols-3">
            <div class="card-anim">
              <img src="images/2.jpg" alt="Vanga" class="w-full h-56 object-cover" />
              <div class="p-6 text-left">
                <h4 class="card-title">Vanga de Van Dam</h4>
                <p class="card-text">Un oiseau rare et endémique, trésor des forêts sèches du nord de l'île.</p>
              </div>
            </div>
            <div class="card-anim delay-200">
              <img src="images/3.jpg" alt="Coua" class="w-full h-56 object-cover" />
              <div class="p-6 text-left">
                <h4 class="card-title">Coua Bleu</h4>
                <p class="card-text">Avec son plumage vibrant et son œil cerclé de bleu, le Coua est un spectacle inoubliable.</p>
              </div>
            </div>
            <div class="card-anim delay-400">
              <img src="images/4.jpg" alt="Indri" class="w-full h-56 object-cover" />
              <div class="p-6 text-left">
                <h4 class="card-title">L'Indri Indri</h4>
                <p class="card-text">Bien qu'il ne soit pas un oiseau, son chant puissant résonne dans la canopée aux côtés des oiseaux.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- TOURS -->
      <section id="tours" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
          <h3 class="section-title">🗺️ Nos Itinéraires d'Exception</h3>
          <p class="section-subtitle">Des circuits conçus par des experts pour maximiser vos chances d'observation.</p>
          <div class="grid gap-10 md:grid-cols-3">
            <div class="card-anim">
              <div class="text-3xl mb-4">🌳</div>
              <h4 class="card-title">3 jours – Forêts de l'Est</h4>
              <p class="card-text">Une immersion intense dans le parc d'Andasibe pour découvrir l'Indri et les oiseaux forestiers rares.</p>
              <a href="#" class="link-more">En savoir plus →</a>
            </div>
            <div class="card-anim delay-200">
              <div class="text-3xl mb-4">🌵</div>
              <h4 class="card-title">7 jours – Le Grand Sud</h4>
              <p class="card-text">Explorez les paysages spectaculaires du parc de l'Isalo et les oiseaux des forêts épineuses près d'Ifaty.</p>
              <a href="#" class="link-more">En savoir plus →</a>
            </div>
            <div class="card-anim delay-400">
              <div class="text-3xl mb-4">🌍</div>
              <h4 class="card-title">12 jours – Le Tour Complet</h4>
              <p class="card-text">Un circuit complet, de la canopée humide de l'Est aux baobabs de l'Ouest, pour une aventure totale.</p>
              <a href="#" class="link-more">En savoir plus →</a>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- FOOTER -->
    <footer class="py-8 text-center text-slate-500 text-sm bg-slate-100 animate-fadeUp">
      © {{ new Date().getFullYear() }} Momotas-bird
    </footer>
  </div>
</template>

<style>
/* Keyframes perso */
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}
@keyframes fadeDown {
  0% { opacity: 0; transform: translateY(-30px); }
  100% { opacity: 1; transform: translateY(0); }
}
@keyframes zoomInSlow {
  0% { transform: scale(1.15); opacity: 0.8; }
  100% { transform: scale(1); opacity: 1; }
}
@keyframes bounceSlow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

/* Utilitaires */
.animate-fadeUp { animation: fadeUp 1s ease forwards; }
.animate-fadeDown { animation: fadeDown 1s ease forwards; }
.animate-zoomInSlow { animation: zoomInSlow 8s ease-out forwards; }
.animate-bounceSlow { animation: bounceSlow 2.5s infinite; }

/* Classes simplifiées */
.nav-link { @apply text-gray-600 hover:text-emerald-600 font-medium transition-colors; }
.btn-cta { @apply bg-emerald-500 text-white px-6 py-3 rounded-full font-bold shadow-md hover:bg-emerald-600 transition transform hover:scale-110; }
.section-title { @apply text-4xl md:text-5xl font-bold text-emerald-600 mb-4; }
.section-subtitle { @apply text-lg text-slate-600 mb-16 max-w-2xl mx-auto; }
.card-anim { @apply bg-white rounded-xl shadow-lg overflow-hidden p-6 transform opacity-0 translate-y-10 transition-all duration-700; animation: fadeUp 1s forwards; }
.card-title { @apply text-2xl font-semibold mb-2 text-gray-900; }
.card-text { @apply text-gray-600 leading-relaxed; }
.link-more { @apply font-bold text-emerald-600 hover:text-emerald-700 transition; }
</style>
