<section class="py-5 overflow-hidden">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">
            
            <h2 class="section-title">Newly Arrived Brands</h2>

            <div class="d-flex align-items-center">
              <a href="#" class="btn-link text-decoration-none">View All Brands →</a>
              <div class="swiper-buttons">
                <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
              </div>  
            </div>
          </div>
          
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="brand-carousel swiper">
            <div class="swiper-wrapper">
              @foreach ($brands as $brand)
              <div class="swiper-slide">
                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                  <div class="row g-0">
                    <div class="col-md-4">
                      <img src="{{ asset('/storage/' . $brand->image) }}" class="img-fluid rounded" alt="Card title">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body bg-transparent py-0">
                        <p class="text-muted mb-0">{{ $brand->name }}</p>
                        <h5 class="card-title">{{ $brand->description }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>              
               @endforeach
              
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  