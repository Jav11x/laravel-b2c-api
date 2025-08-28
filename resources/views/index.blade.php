<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Listado de productos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <style>body{padding:20px}table td,table th{vertical-align:middle}</style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4">Productos</h1>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-3">
        <label class="form-label">Categoría</label>
        <select id="filter-category" class="form-select"><option value="">Todas</option></select>
      </div>
      <div class="col-12 col-md-3">
        <label class="form-label">Estado</label>
        <select id="filter-active" class="form-select">
          <option value="">Todos</option><option value="true">Activo</option><option value="false">Inactivo</option>
        </select>
      </div>
      <div class="col-12 col-md-3 align-self-end"><button id="btn-filter" class="btn btn-primary w-100">Filtrar</button></div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped" id="tbl-products">
        <thead><tr><th>Nombre</th><th>Precio</th><th>Stock</th><th>Categoría</th><th>Estado</th></tr></thead>
        <tbody></tbody>
      </table>
    </div>
    <nav><ul class="pagination" id="pagination"></ul></nav>
    <hr class="my-4" />
    <h2>Nuevo producto</h2>
    <form id="frm-new" class="row g-3">
      <div class="col-md-4"><label class="form-label">Nombre</label><input name="name" class="form-control" required /></div>
      <div class="col-md-2"><label class="form-label">Precio</label><input name="price" type="number" step="0.01" min="0.01" class="form-control" required /></div>
      <div class="col-md-2"><label class="form-label">Stock</label><input name="stock" type="number" min="0" class="form-control" required /></div>
      <div class="col-md-3"><label class="form-label">Categoría</label><select name="category_id" class="form-select" required></select></div>
      <div class="col-md-1 align-self-end"><button class="btn btn-success w-100">Crear</button></div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
