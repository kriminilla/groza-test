import EmblaCarousel from 'embla-carousel'
import Autoplay from 'embla-carousel-autoplay'

const rootNode = document.querySelector('.embla')
const viewportNode = rootNode.querySelector('.embla__viewport')
const prevButtonNode = rootNode.querySelector('.embla__prev')
const nextButtonNode = rootNode.querySelector('.embla__next')

const options = { loop: true } // kalau mau infinite
const plugins = [Autoplay({ delay: 3000 })] // autoplay 3 detik

const emblaApi = EmblaCarousel(viewportNode, options, plugins)

prevButtonNode.addEventListener('click', () => emblaApi.scrollPrev(), false)
nextButtonNode.addEventListener('click', () => emblaApi.scrollNext(), false)
