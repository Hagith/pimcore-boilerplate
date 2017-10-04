<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="/">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
          data-target="#main-navbar" aria-controls="main-navbar"
          aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="main-navbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">
      <a href="http://www.pimcore.org/" id="logo">Pimcore</a>
    </h1>
    <p>THE OPEN-SOURCE ENTERPRISE PLATFORM FOR PIM, CMS, DAM & COMMERCE</p>
    <p>
      <a class="btn btn-primary btn-lg" href="http://www.pimcore.org/" role="button">
        Learn more &raquo;
      </a>
    </p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <h2>Where can I edit some pages?</h2>
      <p>
        Well, it seems that you're using the professional distribution of pimcore which includes
        only basic template using
        <a href="http://getbootstrap.com/" target="_blank">Bootstrap 4.0</a>
        theme. It's designed to start a project from scratch. If you need a jump start please
        consider using our sample data / boilerplate package which includes everything you need
        to get started.
      </p>
      <p>
        <a target="_blank" href="https://www.pimcore.org/wiki/pages/viewpage.action?pageId=16854186"
           class="btn btn-outline-primary">
          Install Sample Data / Boilerplate</a>
        <a target="_blank" href="http://www.pimcore.org/wiki/display/PIMCORE4/Develop+with+pimcore"
           class="btn btn-outline-primary">
          Getting Started</a>
      </p>
    </div>
  </div>

  <footer>
    <hr>
    <p>&copy; <?= date('Y') ?> pimcore GmbH</p>
  </footer>
</div>
