<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { ScrollSmoother } from 'gsap/ScrollSmoother'
import { SplitText } from 'gsap/SplitText'
import { CustomEase } from 'gsap/all'
import { ScrollToPlugin } from 'gsap/ScrollToPlugin'

gsap.registerPlugin(ScrollTrigger, ScrollSmoother, SplitText, CustomEase, ScrollToPlugin)

CustomEase.create('premium', '0.76, 0, 0.24, 1')
CustomEase.create('soft', '0.25, 0.46, 0.45, 0.94')

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  circuits: { type: Array, required: true }
})

const form = useForm({ name: '', email: '', message: '' })
const messageSent = ref(false)
const menuOpen = ref(false)

function submit() {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess() {
      form.reset()
      messageSent.value = true
      setTimeout(() => (messageSent.value = false), 5000)
    }
  })
}

function scrollToSection(id) {
  menuOpen.value = false
  const el = document.getElementById(id)
  if (el) {
    gsap.to(window, {
      duration: 1.2,
      scrollTo: { y: el, offsetY: 80 },
      ease: 'soft'
    })
  }
}

/* ===== HERO SLIDER ===== */
const heroSlides = [
  { id: 1, src: '/images/2.jpg', title: "Van Dam's Vanga", subtitle: 'Rare endemic species' },
  { id: 2, src: '/images/12.jpg', title: "Schlegel's Asity", subtitle: 'Ranomafana, Andasibe, Montagne d’Ambre, Marojejy' },
  { id: 3, src: '/images/13.jpg', title: 'Sickle-Billed Vanga', subtitle: 'Ifaty, Tsimanampetsotse, Ankarafantsika, Ankarana' },
  { id: 4, src: '/images/3.jpg', title: 'Blue Coua', subtitle: 'Jewel of the forest' },
  { id: 5, src: '/images/15.jpg', title: 'Broad-billed roller', subtitle: 'Ranomafana, Isalo, Zombitse, Ankarafantsika' },
  { id: 6, src: '/images/16.jpg', title: 'Littoral rock Thrush', subtitle: 'Ifaty, Tsimanampetsotse' },
  { id: 7, src: '/images/5.jpg', title: 'Bird of Paradise', subtitle: 'Tropical beauty' }
]

const galleryImages = [
  { id: 1, src: '/images/2.jpg', name: "Van Dam's Vanga" },
  { id: 2, src: '/images/3.jpg', name: 'Blue Coua' },
  { id: 3, src: '/images/4.jpg', name: 'Indri Lemur' },
  { id: 4, src: '/images/5.jpg', name: 'Bird of Paradise' },
  { id: 5, src: '/images/6.jpg', name: 'Madagascar Fish Eagle' },
  { id: 6, src: '/images/7.jpg', name: 'Blue Vanga' }
]

const testimonials = [
  { id: 1, name: 'Sarah Johnson', location: 'United Kingdom', rating: 5, text: 'An absolutely incredible experience! The guides were so knowledgeable and we saw over 50 different bird species. The accommodation was excellent too.', image: '/images/testimonial1.jpg' },
  { id: 2, name: 'Marie Dubois', location: 'France', rating: 5, text: 'Magique! Nous avons vu des oiseaux que nous n\'aurions jamais imaginés. L\'organisation était parfaite du début à la fin.', image: '/images/testimonial2.jpg' },
  { id: 3, name: 'Carlos Rodriguez', location: 'Spain', rating: 5, text: 'Professional, passionate and patient guides. The Indri lemur encounter was unforgettable. Highly recommend!', image: '/images/testimonial3.jpg' }
]

onMounted(() => {
  ScrollSmoother.create({ smooth: 1.5, effects: true, smoothTouch: 0.1 })

  const slides = document.querySelectorAll('.hero-slide')
  let current = 0

  function showSlide(index) {
    gsap.fromTo(slides[index], { opacity: 0, scale: 1.1 }, { opacity: 1, scale: 1, duration: 1.5, ease: 'premium' })
    const split = SplitText.create(slides[index].querySelectorAll('h2, p'), { type: 'lines' })
    gsap.from(split.lines, { y: 60, opacity: 0, stagger: 0.08, duration: 1, ease: 'soft' })
    slides.forEach((slide, i) => i !== index && gsap.to(slide, { opacity: 0, scale: 1.05, duration: 1, ease: 'premium' }))
  }
  function nextSlide() { current = (current + 1) % slides.length; showSlide(current) }
  showSlide(0)
  setInterval(nextSlide, 5000)

  document.fonts.ready.then(() => {
    const split = SplitText.create('.hero-main-title', { type: 'chars' })
    gsap.timeline()
      .from(split.chars, { y: 120, opacity: 0, rotationX: -90, stagger: 0.05, duration: 1.5, ease: 'premium' })
      .from('.hero-main-sub', { y: 50, opacity: 0, duration: 1, ease: 'soft' }, '-=0.5')
      .from('.hero-cta', { scale: 0.8, opacity: 0, duration: 1, ease: 'premium' }, '-=0.3')
  })

  gsap.utils.toArray('.section-reveal').forEach(el => {
    const split = SplitText.create(el, { type: 'lines' })
    gsap.from(split.lines, {
      y: 80, opacity: 0, stagger: 0.06, duration: 1, ease: 'premium',
      scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play reverse play reverse' }
    })
  })
  gsap.utils.toArray('.card-item').forEach((card, i) =>
    gsap.from(card, {
      y: 100, opacity: 0, duration: 1, delay: i * 0.1, ease: 'premium',
      scrollTrigger: { trigger: card, start: 'top 85%', toggleActions: 'play reverse play reverse' }
    })
  )
  gsap.utils.toArray('.testimonial-card').forEach((card, i) =>
    gsap.from(card, {
      y: 80, opacity: 0, duration: 1, delay: i * 0.15, ease: 'soft',
      scrollTrigger: { trigger: card, start: 'top 85%', toggleActions: 'play reverse play reverse' }
    })
  )

  const cursor = document.querySelector('.cursor-follower')
  if (cursor && window.innerWidth > 768) {
    let mx = 0, my = 0, cx = 0, cy = 0
    document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY })
    const anim = () => { cx += (mx - cx) * 0.1; cy += (my - cy) * 0.1; gsap.set(cursor, { x: cx, y: cy }); requestAnimationFrame(anim) }
    anim()
  }
})
</script>

<template>
  <Head title="Momotas Bird - Premium Birdwatching in Madagascar" />

  <!-- CURSOR -->
  <div class="cursor-follower hidden md:block fixed w-5 h-5 rounded-full bg-amber-400/60 pointer-events-none z-[999] mix-blend-multiply" />

  <div id="smooth-wrapper">
    <div id="smooth-content">
      <!-- HEADER -->
      <header class="fixed top-0 left-0 w-full z-50 py-4 px-6 md:px-12 bg-black/30 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
          <Link href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-400/20 rounded-full flex items-center justify-center group-hover:bg-amber-400/30 transition">
              <img src="/images/logo.png" alt="Logo" class="h-6 w-6 md:h-8 md:w-8 object-contain">
            </div>
            <span class="text-amber-400 text-lg md:text-xl font-light tracking-[0.3em] uppercase">Momotas</span>
          </Link>

          <!-- Desktop Nav -->
          <nav class="hidden md:flex items-center gap-6 lg:gap-10">
            <a href="#" @click.prevent="scrollToSection('tours')" class="text-gray-200 hover:text-amber-400 transition">Tours</a>
            <a href="#" @click.prevent="scrollToSection('gallery')" class="text-gray-200 hover:text-amber-400 transition">Gallery</a>
            <a href="#" @click.prevent="scrollToSection('about')" class="text-gray-200 hover:text-amber-400 transition">About</a>
            <a href="#" @click.prevent="scrollToSection('contact')" class="text-gray-200 hover:text-amber-400 transition">Contact</a>
          </nav>

          <!-- Desktop Auth -->
          <div class="hidden md:flex items-center gap-3 lg:gap-4">
            <template v-if="!$page.props.auth.user">
              <Link v-if="canLogin" :href="route('login')" class="text-gray-200 hover:text-amber-400 transition text-sm lg:text-base">Log in</Link>
              <!-- <Link v-if="canRegister" :href="route('register')" class="bg-amber-500 text-black px-3 py-2 lg:px-4 lg:py-2 rounded-full text-sm font-medium hover:bg-amber-400 transition">Register</Link> -->
            </template>
            <Link v-else :href="route('dashboard')" class="bg-amber-500 text-black px-3 py-2 lg:px-4 lg:py-2 rounded-full text-sm font-medium hover:bg-amber-400 transition">Dashboard</Link>
          </div>

          <!-- Burger -->
          <button @click="menuOpen = !menuOpen" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Mobile Menu -->
        <transition name="slide">
          <div v-if="menuOpen" class="md:hidden mt-4 pb-4 border-t border-white/10">
            <nav class="flex flex-col gap-4 mt-4">
              <a href="#" @click.prevent="scrollToSection('tours')" class="text-gray-200 hover:text-amber-400 transition">Tours</a>
              <a href="#" @click.prevent="scrollToSection('gallery')" class="text-gray-200 hover:text-amber-400 transition">Gallery</a>
              <a href="#" @click.prevent="scrollToSection('about')" class="text-gray-200 hover:text-amber-400 transition">About</a>
              <a href="#" @click.prevent="scrollToSection('contact')" class="text-gray-200 hover:text-amber-400 transition">Contact</a>
              <div class="flex items-center gap-3 pt-2">
                <template v-if="!$page.props.auth.user">
                  <Link v-if="canLogin" :href="route('login')" class="text-gray-200 hover:text-amber-400 transition">Log in</Link>
                  <Link v-if="canRegister" :href="route('register')" class="bg-amber-500 text-black px-4 py-2 rounded-full text-sm font-medium hover:bg-amber-400 transition">Register</Link>
                </template>
                <Link v-else :href="route('dashboard')" class="bg-amber-500 text-black px-4 py-2 rounded-full text-sm font-medium hover:bg-amber-400 transition">Dashboard</Link>
              </div>
            </nav>
          </div>
        </transition>
      </header>

      <!-- HERO SLIDER -->
      <section class="hero-section relative h-screen overflow-hidden bg-gradient-to-b from-amber-50 to-orange-100">
        <div class="hero-slides absolute inset-0">
          <div v-for="(slide, i) in heroSlides" :key="slide.id" class="hero-slide absolute inset-0 w-full h-full" :class="{ 'active': i === 0 }" :style="{ zIndex: heroSlides.length - i }">
            <img :src="slide.src" :alt="slide.title" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            <div class="hero-text-inner absolute bottom-10 md:bottom-20 left-6 md:left-10 text-white">
              <h2 class="text-3xl md:text-6xl font-light mb-1 md:mb-2">{{ slide.title }}</h2>
              <p class="text-base md:text-xl text-amber-200">{{ slide.subtitle }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- STATS -->
      <!-- <section id="about" class="py-16 md:py-20 bg-gradient-to-b from-amber-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
            <div class="section-reveal">
              <div class="text-4xl md:text-6xl font-bold text-amber-600 mb-2">150+</div>
              <p class="text-amber-800/80 text-sm md:text-base">Bird Species</p>
            </div>
            <div class="section-reveal">
              <div class="text-4xl md:text-6xl font-bold text-amber-600 mb-2">12</div>
              <p class="text-amber-800/80 text-sm md:text-base">Years Experience</p>
            </div>
            <div class="section-reveal">
              <div class="text-4xl md:text-6xl font-bold text-amber-600 mb-2">500+</div>
              <p class="text-amber-800/80 text-sm md:text-base">Happy Clients</p>
            </div>
            <div class="section-reveal">
              <div class="text-4xl md:text-6xl font-bold text-amber-600 mb-2">25</div>
              <p class="text-amber-800/80 text-sm md:text-base">Unique Locations</p>
            </div>
          </div>
        </div>
      </section> -->

      <!-- TOURS -->
      <section id="tours" class="py-20 md:py-32 bg-gradient-to-b from-orange-100 to-amber-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="text-center mb-16 md:mb-24">
            <h2 class="section-reveal text-4xl md:text-7xl font-light text-amber-800 mb-4 md:mb-6">Premium Expeditions</h2>
            <p class="section-reveal text-lg md:text-xl text-amber-700/80 max-w-3xl mx-auto">Carefully crafted circuits for discerning travelers seeking extraordinary wildlife encounters</p>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <div v-for="c in circuits" :key="c.id" class="card-item group relative bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-700">
              <div class="overflow-hidden">
                <img :src="'/storage/'+c.image" :alt="c.title" class="w-full h-64 md:h-80 object-cover group-hover:scale-110 transition-transform duration-700">
              </div>
              <div class="p-6 md:p-8">
                <h3 class="text-xl md:text-2xl font-semibold text-amber-800 mb-3 md:mb-4">{{ c.title }}</h3>
                <p class="text-amber-700/80 mb-4 md:mb-6 line-clamp-3 text-sm md:text-base">{{ c.description }}</p>
                <div class="flex items-center justify-between">
                  <Link :href="route('itineraires.show', c.id)" class="group font-medium text-amber-600 hover:text-amber-700 flex items-center gap-2 transition text-sm md:text-base">Discover Tour <span class="transform group-hover:translate-x-2 transition-transform">&rarr;</span></Link>
                  <div class="flex items-center gap-1 text-amber-500 text-sm md:text-base"><span v-for="i in 5" :key="i">★</span></div>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-16 md:mt-24">
            <Link :href="route('itineraires.index')" class="inline-block bg-amber-500 text-black px-8 py-3 md:px-10 md:py-4 rounded-full font-medium uppercase tracking-wider shadow-2xl hover:bg-amber-400 transition-all duration-300 text-sm md:text-base">View All Tours</Link>
          </div>
        </div>
      </section>

      <!-- TESTIMONIALS -->
      <section class="py-20 md:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="text-center mb-16 md:mb-24">
            <h2 class="section-reveal text-4xl md:text-7xl font-light text-amber-800 mb-4 md:mb-6">Traveler Stories</h2>
            <p class="section-reveal text-lg md:text-xl text-amber-700/80 max-w-3xl mx-auto">Real experiences from our delighted travelers</p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <div v-for="testimonial in testimonials" :key="testimonial.id" class="testimonial-card bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
              <div class="flex mb-3 md:mb-4"><span v-for="i in 5" :key="i" class="text-amber-400 text-base md:text-lg">★</span></div>
              <p class="text-amber-800/90 mb-4 md:mb-6 italic text-base md:text-lg leading-relaxed">"{{ testimonial.text }}"</p>
              <div class="flex items-center gap-3 md:gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-200 rounded-full flex items-center justify-center"><span class="text-amber-800 font-semibold">{{ testimonial.name.charAt(0) }}</span></div>
                <div>
                  <p class="font-semibold text-amber-800 text-sm md:text-base">{{ testimonial.name }}</p>
                  <p class="text-xs md:text-sm text-amber-600/80">{{ testimonial.location }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- GALLERY -->
      <section id="gallery" class="py-20 md:py-32 bg-gradient-to-b from-amber-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="text-center mb-16 md:mb-24">
            <h2 class="section-reveal text-4xl md:text-7xl font-light text-amber-800 mb-4 md:mb-6">Avian Gallery</h2>
            <p class="section-reveal text-lg md:text-xl text-amber-700/80 max-w-3xl mx-auto">A glimpse of the breathtaking beauty of Madagascar's endemic species</p>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 md:gap-6">
            <div v-for="img in galleryImages" :key="img.id" class="card-item group relative rounded-xl overflow-hidden aspect-square cursor-pointer">
              <img :src="img.src" :alt="img.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <div class="absolute bottom-4 left-4 md:bottom-6 md:left-6"><h3 class="text-white text-sm md:text-lg font-medium">{{ img.name }}</h3></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CONTACT -->
      <section id="contact" class="py-20 md:py-32 bg-gradient-to-b from-orange-100 to-amber-50">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
          <div class="text-center mb-16 md:mb-24">
            <h2 class="section-reveal text-3xl md:text-6xl font-light text-amber-800 mb-4 md:mb-6">Ready to Start?</h2>
            <p class="section-reveal text-base md:text-xl text-amber-700/80 max-w-2xl mx-auto">Contact our expedition specialists to craft your perfect birdwatching adventure</p>
          </div>
          <div v-if="messageSent" class="mb-6 md:mb-8 bg-amber-500/10 border border-amber-500/30 text-amber-700 px-4 py-3 md:px-6 md:py-4 rounded-xl text-center text-sm md:text-base"><strong>Message sent successfully!</strong> We'll get back to you within 24 hours.</div>
          <form @submit.prevent="submit" class="max-w-2xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
              <div>
                <label for="name" class="block text-sm font-medium text-amber-800 mb-2 md:mb-3">Name</label>
                <input type="text" required v-model="form.name" id="name" class="w-full bg-white/70 border border-amber-200 rounded-xl py-3 px-4 md:py-4 md:px-6 text-amber-900 placeholder-amber-400 focus:outline-none focus:border-amber-500 transition text-sm md:text-base">
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-amber-800 mb-2 md:mb-3">Email</label>
                <input id="email" required v-model="form.email" type="email" class="w-full bg-white/70 border border-amber-200 rounded-xl py-3 px-4 md:py-4 md:px-6 text-amber-900 placeholder-amber-400 focus:outline-none focus:border-amber-500 transition text-sm md:text-base">
              </div>
            </div>
            <div class="mt-6 md:mt-8">
              <label for="message" class="block text-sm font-medium text-amber-800 mb-2 md:mb-3">Message</label>
              <textarea id="message" required v-model="form.message" rows="5" class="w-full bg-white/70 border border-amber-200 rounded-xl py-3 px-4 md:py-4 md:px-6 text-amber-900 placeholder-amber-400 focus:outline-none focus:border-amber-500 transition text-sm md:text-base"></textarea>
            </div>
            <div class="mt-8 md:mt-12 text-center">
              <button :disabled="form.processing" type="submit" class="inline-block bg-amber-500 text-black px-8 py-3 md:px-12 md:py-5 rounded-full font-medium uppercase tracking-wider shadow-2xl hover:bg-amber-400 transition-all duration-300 disabled:opacity-50 text-sm md:text-base"><span v-if="form.processing">Sending...</span><span v-else>Send Inquiry</span></button>
            </div>
          </form>
        </div>
      </section>

      <!-- FOOTER -->
      <footer class="bg-gradient-to-b from-amber-50 to-orange-100 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
          <p class="text-xs md:text-sm text-amber-600/60">© {{ new Date().getFullYear() }} Momotas Bird. All rights reserved.</p>
        </div>
      </footer>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
.main-container{font-family:'Inter',sans-serif;background:#fff;color:#444;cursor:none}
.cursor-follower{position:fixed;width:18px;height:18px;background:#f59e16;border-radius:50%;pointer-events:none;z-index:9999;mix-blend-mode:multiply;transition:transform .1s ease}
::-webkit-scrollbar{width:10px}
::-webkit-scrollbar-track{background:#fff7ed}
::-webkit-scrollbar-thumb{background:#f59e16;border-radius:5px}
::-webkit-scrollbar-thumb:hover{background:#ea580c}
.section-reveal{line-height:1.2}
*{transition-timing-function:cubic-bezier(.76,0,.24,1)}
.slide-enter-active,.slide-leave-active{transition:max-height .3s ease}
.slide-enter-to,.slide-enter-from{max-height:0;overflow:hidden}
</style>