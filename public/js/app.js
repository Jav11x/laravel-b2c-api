const API = location.origin + '/api';

async function fetchJSON(url, opts) {
  const res = await fetch(url, opts);
  if (!res.ok) throw new Error(await res.text());
  return res.json();
}

async function loadCategories() {
  const cats = await fetchJSON(`${API}/categories`);
  const selFilter = document.querySelector('#filter-category');
  const selForm = document.querySelector('select[name="category_id"]');
  cats.forEach(c => {
    selFilter.add(new Option(c.name, c.id));
    selForm.add(new Option(c.name, c.id));
  });
}

let state = { page: 1, per_page: 10, category_id: '', active: '' };

async function loadProducts() {
  const params = new URLSearchParams();
  params.set('per_page', state.per_page);
  if (state.category_id) params.set('category_id', state.category_id);
  if (state.active !== '') params.set('active', state.active);
  params.set('page', state.page);
  const data = await fetchJSON(`${API}/products?${params.toString()}`);
  renderTable(data);
  renderPagination(data);
}

function renderTable(data) {
  const tbody = document.querySelector('#tbl-products tbody');
  tbody.innerHTML = '';
  data.data.forEach(p => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${p.name}</td>
      <td>${Number(p.price).toFixed(2)} €</td>
      <td>${p.stock}</td>
      <td>${p.category?.name ?? '-'}</td>
      <td>
        <input type="checkbox" ${p.active ? 'checked' : ''} data-id="${p.id}" class="toggle-active"/>
        <span class="ms-2">${p.active ? 'Activo' : 'Inactivo'}</span>
      </td>`;
    tbody.appendChild(tr);
  });
  tbody.querySelectorAll('.toggle-active').forEach(chk => {
    chk.addEventListener('change', async (e) => {
      const id = e.target.dataset.id;
      const active = e.target.checked;
      await fetchJSON(`${API}/products/${id}`, {
        method: 'PUT', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ active })
      });
      loadProducts();
    });
  });
}

function renderPagination(data) {
  const ul = document.querySelector('#pagination');
  ul.innerHTML = '';
  const { current_page, last_page } = data.meta;
  for (let i = 1; i <= last_page; i++) {
    const li = document.createElement('li');
    li.className = `page-item ${i === current_page ? 'active' : ''}`;
    const a = document.createElement('a');
    a.className = 'page-link';
    a.href = '#'; a.textContent = i;
    a.onclick = (ev) => { ev.preventDefault(); state.page = i; loadProducts(); };
    li.appendChild(a); ul.appendChild(li);
  }
}

document.querySelector('#btn-filter').addEventListener('click', () => {
  state.category_id = document.querySelector('#filter-category').value;
  state.active = document.querySelector('#filter-active').value;
  state.page = 1; loadProducts();
});

const form = document.querySelector('#frm-new');
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!form.checkValidity()) { e.stopPropagation(); form.classList.add('was-validated'); return; }
  const data = Object.fromEntries(new FormData(form).entries());
  data.price = parseFloat(data.price);
  data.stock = parseInt(data.stock);
  data.active = true;
  await fetchJSON(`${API}/products`, {
    method: 'POST', headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
  form.reset(); form.classList.remove('was-validated');
  loadProducts();
});

loadCategories().then(loadProducts);
