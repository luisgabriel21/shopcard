@aware(['page'])
<section class="text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
      <div class="lg:w-4/5 mx-auto flex flex-wrap">
        <div class="lg:w-1/2 w-full lg:pr-10 lg:py-6 mb-6 lg:mb-0">
          <h2 class="text-sm title-font text-gray-500 tracking-widest">Shopcard</h2>
          <h1 class="text-gray-900 text-3xl title-font font-medium mb-4">{{$title}}</h1>
          <div class="flex mb-4">
            <a class="flex-grow text-blue-500 border-b-2 border-blue-500 py-2 text-lg px-1">{{$aliado}}</a>
          </div>
          <p class="leading-relaxed mb-4" data-html="true">
            {{ $description }}
          </p>
          <div class="flex border-t border-gray-200 py-2">
            <span class="text-gray-500">Fecha de inicio:</span>
            <span class="ml-auto text-gray-900">{{ $fechaini }}</span>
          </div>
          <div class="flex border-t border-gray-200 py-2">
            <span class="text-gray-500">Fecha de fin:</span>
            <span class="ml-auto text-gray-900">{{ $fechafin }}</span>
          </div>
          <div class="flex">
            <div class="shared-panel">
                <div class="sharing-buttons flex flex-wrap">
                    <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-1 px-2 text-sm rounded text-white border-sky-600 bg-sky-600 hover:bg-sky-700 hover:border-sky-700" target="_blank" rel="noopener" href="https://facebook.com/sharer/sharer.php?u=" aria-label="Share on Facebook">
                      <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                        <title>Facebook</title>
                        <path d="M379 22v75h-44c-36 0-42 17-42 41v54h84l-12 85h-72v217h-88V277h-72v-85h72v-62c0-72 45-112 109-112 31 0 58 3 65 4z">
                        </path>
                      </svg>
                      <span class="ml-1">Facebook</span>
                    </a>
                    <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-1 px-2 text-sm rounded text-white border-sky-600 bg-sky-600 hover:bg-sky-700 hover:border-sky-700" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url=&amp;text=" aria-label="Share on Twitter">
                      <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                        <title>Twitter</title>
                        <path d="m459 152 1 13c0 139-106 299-299 299-59 0-115-17-161-47a217 217 0 0 0 156-44c-47-1-85-31-98-72l19 1c10 0 19-1 28-3-48-10-84-52-84-103v-2c14 8 30 13 47 14A105 105 0 0 1 36 67c51 64 129 106 216 110-2-8-2-16-2-24a105 105 0 0 1 181-72c24-4 47-13 67-25-8 24-25 45-46 58 21-3 41-8 60-17-14 21-32 40-53 55z">
                        </path>
                      </svg>
                      <span class="ml-1">Twitter</span>
                    </a>
                    <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-1 px-2 text-sm rounded text-white border-sky-600 bg-sky-600 hover:bg-sky-700 hover:border-sky-700" target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=&amp;title=&amp;summary=&amp;source=" aria-label="Share on Linkedin">
                      <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                        <title>Linkedin</title>
                        <path d="M136 183v283H42V183h94zm6-88c1 27-20 49-53 49-32 0-52-22-52-49 0-28 21-49 53-49s52 21 52 49zm333 208v163h-94V314c0-38-13-64-47-64-26 0-42 18-49 35-2 6-3 14-3 23v158h-94V183h94v41c12-20 34-48 85-48 62 0 108 41 108 127z">
                        </path>
                      </svg>
                      <span class="ml-1">Linkedin</span>
                    </a>
                  </div>
            </div>
          </div>
        </div>
        <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{asset('storage/'.$image)}}">
      </div>
    </div>
  </section>
<script>

</script>