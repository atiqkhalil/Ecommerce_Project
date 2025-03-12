<footer class="py-5 bg-light text-dark">
  <div class="container">
      <div class="row gy-4 align-items-center">

          <!-- Logo and Social Links -->
          <div class="col-lg-4 text-center text-lg-start">
              <img src="{{ asset('front-assets/images/logo.png') }}" alt="Foodmart Logo" class="mb-3" style="max-width: 160px;">
              <div class="mt-3">
                  <ul class="list-unstyled d-flex gap-3 justify-content-center justify-content-lg-start">
                      <li>
                          <a href="#" class="social-icon">
                              <i class="fab fa-facebook-f"></i>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="social-icon">
                              <i class="fab fa-twitter"></i>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="social-icon">
                              <i class="fab fa-youtube"></i>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="social-icon">
                              <i class="fab fa-instagram"></i>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="social-icon">
                              <i class="fab fa-linkedin-in"></i>
                          </a>
                      </li>
                  </ul>
              </div>
          </div>

          <!-- Quick Links -->
          <div class="col-lg-3 col-md-6">
              <h5 class="fw-bold mb-3">Company</h5>
              <ul class="list-unstyled">
               @foreach ($pages as $page)
               <li><a href="{{ route('front.page',$page->slug) }}" class="footer-link">{{ $page->name }}</a></li>
               @endforeach                     
              </ul>
          </div>

          <!-- Customer Support -->
          <div class="col-lg-3 col-md-6">
              <h5 class="fw-bold mb-3">My Account</h5>
              <ul class="list-unstyled">
                  <li><a href="{{ route('login') }}" class="footer-link">Login</a></li>
                  <li><a href="{{ route('account.register') }}" class="footer-link">Register</a></li>
                  <li><a href="{{ route('account.orders') }}" class="footer-link">My Orders</a></li>
              </ul>
          </div>

          <!-- Newsletter -->
          <div class="col-lg-2 text-center text-lg-start">
              <h5 class="fw-bold mb-3">Stay Updated</h5>
              <form>
                  <div class="input-group">
                      <input type="email" class="form-control" placeholder="Your email">
                      <button class="btn btn-primary" type="submit">Subscribe</button>
                  </div>
              </form>
          </div>

      </div>
  </div>
</footer>

<!-- Footer Bottom -->
<div class="footer-bottom bg-black text-white py-3">
  <div class="container">
      <div class="row">
          <div class="col-md-6 text-center text-md-start">
              <p class="mb-0">© 2025 Foodmart. All rights reserved.</p>
          </div>
          <div class="col-md-6 text-center text-md-end">
              <p class="mb-0">Made by Atiq Khalil</p>
          </div>
      </div>
  </div>
</div>

<!-- CSS Styles -->
<style>
  .social-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 35px;
      height: 35px;
      background: rgba(5, 5, 5, 0.2);
      border-radius: 50%;
      color: black;
      transition: all 0.3s ease-in-out;
      text-decoration: none;
  }

  .social-icon:hover {
      background: #f8b400;
      color: #fff;
  }

  .footer-link {
      color: #bbb;
      text-decoration: none;
      transition: color 0.3s;
  }

  .footer-link:hover {
      color: #f8b400;
  }

  .footer-bottom {
      font-size: 0.875rem;
  }
</style>
