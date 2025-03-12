{{-- <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary"><li class="">
            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#cart"></use>
                </svg>
            </a>
        </li></span>
        </h4>
        <ul class="list-group mb-3">
          @foreach ($cartContents as $cartContent)
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">{{ $cartContent->name }}</h6>
              <small class="text-body-secondary" name = "shortDescription">{{ $cartContent->short_description }}</small>
            </div>
            <span class="text-body-secondary">${{ $cartContent->price }}</span>
          </li>
          @endforeach
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$20</strong>
          </li>
        </ul>

        <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
      </div>
    </div>
  </div> --}}