<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insurance Quotation</title>
</head>
<body>

<div id="login-section">
    <h2>Login</h2>
    <form id="login-form">
        <div><label>Email <input id="email" type="email" required></label></div>
        <div><label>Password <input id="password" type="password" required></label></div>
        <div id="login-error"></div>
        <button type="submit">Login</button>
    </form>
</div>

<div id="quotation-section" hidden>
    <h2>Get a Quote</h2>
    <form id="quotation-form">
        <div><label>Age(s) 18-70 (comma-separated) <input id="age" type="text" placeholder="e.g. 25, 35, 45" required></label></div>
        <div><label>Start date <input id="start_date" type="date" required></label></div>
        <div><label>End date <input id="end_date" type="date" required></label></div>
        <div>
            <label>Currency
                <select id="currency_id" required>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                </select>
            </label>
        </div>
        <div id="quotation-error"></div>
        <button type="submit">Calculate</button>
    </form>
    <pre id="result" hidden></pre>
    <br><button id="logout-btn">Logout</button>
</div>

<script>
const API = '/api';

function show(id) {
    document.getElementById('login-section').hidden = (id !== 'login-section');
    document.getElementById('quotation-section').hidden = (id !== 'quotation-section');
}

if (localStorage.getItem('jwt_token')) {
    show('quotation-section');
}

document.getElementById('login-form').addEventListener('submit', async e => {
    e.preventDefault();
    document.getElementById('login-error').textContent = '';

    const res = await fetch(`${API}/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ email: document.getElementById('email').value, password: document.getElementById('password').value }),
    });

    const data = await res.json();

    if (!res.ok) {
        document.getElementById('login-error').textContent = data.message ?? 'Login failed.';
        return;
    }

    localStorage.setItem('jwt_token', data.token.access_token);
    document.getElementById('password').value = '';
    show('quotation-section');
});

document.getElementById('logout-btn').addEventListener('click', async () => {
    const token = localStorage.getItem('jwt_token');
    await fetch(`${API}/auth/logout`, {
        method: 'POST',
        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' },
    }).catch(() => {});
    localStorage.removeItem('jwt_token');
    document.getElementById('result').hidden = true;
    show('login-section');
});

document.getElementById('quotation-form').addEventListener('submit', async e => {
    e.preventDefault();
    document.getElementById('quotation-error').textContent = '';
    document.getElementById('result').hidden = true;

    const token = localStorage.getItem('jwt_token');

    const res = await fetch(`${API}/quotation`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': `Bearer ${token}` },
        body: JSON.stringify({
            age:         document.getElementById('age').value,
            start_date:  document.getElementById('start_date').value,
            end_date:    document.getElementById('end_date').value,
            currency_id: document.getElementById('currency_id').value,
        }),
    });

    const data = await res.json();

    if (res.status === 401) { localStorage.removeItem('jwt_token'); show('login-section'); return; }

    if (!res.ok) {
        document.getElementById('quotation-error').textContent = data.message ?? Object.values(data.errors ?? {}).flat().join(' ');
        return;
    }

    const r = document.getElementById('result');
    let text = `Quotation ID: ${data.quotation_id}\n`;
    text += `Currency:     ${data.currency_id}\n`;
    text += `Total:        ${data.total}`;
    r.textContent = text;
    r.hidden = false;
});
</script>

</body>
</html>
