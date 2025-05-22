class Cart {
	constructor() {
		this.cartArray = []
	}

	async loadData() {
		try {
			const res = await fetch('http://localhost/Cart-simulation/api/products.php')
			if (!res.ok) {
				throw new Error(`HTTP error! status: ${res.status}`)
			}
			const data = await res.json()
			this.displayProducts(data)
		} catch (error) {
			console.error(error)
			return
		}
	}

	displayProducts(data) {
		const shop = document.querySelector('.shop__container')
		if (data.status === 'error' || data.data == []) {
			shop.textContent = 'Brak produktów'
		} else {
			const dataArray = data.data
			dataArray.forEach(el => {
				const product = document.createElement('div')
				product.classList.add('product-box')

				const productImg = document.createElement('img')
				productImg.classList.add('product__img')
				productImg.setAttribute('src', `${el.photo_path}`)
				productImg.setAttribute('alt', el.name)
				product.appendChild(productImg)

				const productBody = document.createElement('div')
				productBody.classList.add('product__body')
				product.appendChild(productBody)

				const productTitle = document.createElement('p')
				productTitle.classList.add('product__title')
				productTitle.textContent = el.name
				productBody.appendChild(productTitle)

				const productFooter = document.createElement('div')
				productFooter.classList.add('productFooter')
				productBody.appendChild(productFooter)

				const productPrice = document.createElement('p')
				productPrice.classList.add('product__price')
				productPrice.textContent = `${el.price}$`
				productFooter.appendChild(productPrice)

				const productBtn = document.createElement('button')
				productBtn.classList.add('cart-btn')
				productBtn.innerHTML =
					'<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>'
				productBtn.addEventListener('click', () => cart.addToCart(el))
				productFooter.appendChild(productBtn)

				shop.append(product)
			})
		}
	}

	async addToCart(product) {
		const id = product.id
		try {
			const res = await fetch('http://localhost/Cart-simulation/api/addToCart.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'Application/json',
				},
				credentials: 'include',
				body: JSON.stringify({
					id: id,
				}),
			})

			const data = await res.json()

			if (data.status === 'success') {
				this.createCartProduct(product)
				this.cartArray.push(product)
				this.loadCart()
			}
		} catch (e) {
			console.error('some error try again later')
		}

		this.finalPrice()
		this.handleCounter()
		this.showModal()
	}

	showModal() {
		const modal = document.querySelector('.modalAddToCart')
		modal.classList.add('modal-active')
		setTimeout(() => {
			modal.classList.remove('modal-active')
		}, 1500)
	}

	handleCounter() {
		const counter = document.querySelector('.counter-cart')
		counter.textContent = this.cartArray.length
	}

	async loadCart() {
		try {
			const res = await fetch('http://localhost/Cart-simulation/api/showCart.php', {
				method: 'GET',
				credentials: 'include',
			})

			const data = await res.json()

			if (data.status === 'success') {
				this.cartArray = data.data
			}
		} catch (e) {
			console.error('some error try again later')
		}

		document.querySelector('.cart-container').textContent = ''
		if (this.cartArray.length == 0) {
			document.querySelector('.cart-container').innerHTML = '<p class="fs-3 text-center">The cart is empty</p>'
		} else {
			this.cartArray.forEach(el => {
				this.createCartProduct(el)
			})
		}
		this.finalPrice()
		this.handleCounter()
	}

	createCartProduct(product) {
		const cartContainer = document.querySelector('.cart-container')
		const cartProduct = document.createElement('div')
		cartProduct.classList.add('cart__product')
		cartProduct.innerHTML = `
			<img class="product__img" src="${product.photo_path}" alt="">
			<div class="product__body">
				<p class="product__title">${product.name}</p>
				<p>Tax: 23%</p>
				<div class="d-flex w-100 justify-content-around align-items-center mt-3">
					<p class="product__price mb-0">${product.price}$</p>
					<button class="delBtn" onclick="cart.delFromCart(${product.id})">Delete</button>
				</div>
			</div>
		`
		cartContainer.appendChild(cartProduct)
	}

	finalPrice() {
		let priceQuantity = 0

		this.cartArray.forEach(el => {
			priceQuantity += Number(el.price)
		})
		let finalPrice = priceQuantity * 1.23
		document.querySelector('.final').innerHTML = `Final price <span class="final-price">${finalPrice.toFixed(
			2
		)}$</span>`
	}

	async delFromCart(id) {
		// const index = this.cartArray.findIndex(el => el.id === id)
		console.log(this.cartArray);
		// this.cartArray.splice(index, 1)
		console.log(id);
		try {
			const res = await fetch('http://localhost/Cart-simulation/api/removeFromCart.php', {
				method: 'DELETE',
				credentials: 'include',
				body: JSON.stringify({
					product_id: id
				})
			})

			const data = await res.json()

			if (data.status === 'success') {
				this.loadCart()
			}
		} catch (e) {
			console.error('Some error try again later')
		}
	}
}

const cart = new Cart()

window.addEventListener('load', () => {
	const cartBox = document.querySelector('.cart')
	const authBtnTemplate = document.querySelector('#auth-btn-template')
	const authBtnContainer = document.querySelector('.auth-btns')
	let isLoggedIn = false

	async function checkLogin() {
		const res = await fetch('http://localhost/Cart-simulation/api/checkUser.php', {
			credentials: 'include',
			method: 'GET',
		})

		const data = await res.json()

		if (data.status === 'success') {
			isLoggedIn = true
			showBtns()
		} else {
			isLoggedIn = false
			showBtns()
		}
	}

	function showBtns() {
		if (!isLoggedIn) {
			const btnBox = [
				{ name: 'Login', attr: '#loginModal' },
				{ name: 'Register', attr: '#registerModal' },
			]
			btnBox.forEach(el => {
				const clone = authBtnTemplate.content.cloneNode(true)
				clone.querySelector('.cart-btn').textContent = el.name
				clone.querySelector('.cart-btn').setAttribute('data-bs-target', el.attr)
				authBtnContainer.appendChild(clone)
			})
			const loginForm = document.getElementById('login-form')
			const registerForm = document.getElementById('register-form')
			loginForm.addEventListener('submit', login)
			registerForm.addEventListener('submit', register)
		} else {
			const clone = authBtnTemplate.content.cloneNode(true)
			clone.querySelector('.cart-btn').textContent = 'Logout'
			clone.querySelector('.cart-btn').setAttribute('id', 'logout')
			authBtnContainer.appendChild(clone)
			const logoutBtn = document.getElementById('logout')
			logoutBtn.addEventListener('click', logout)
		}
	}

	async function login(e) {
		e.preventDefault()
		const msgBox = document.getElementById('msg')
		const userData = new FormData(this)
		msgBox.textContent = ''

		try {
			const res = await fetch('http://localhost/Cart-simulation/api/login.php', {
				method: 'POST',
				body: userData,
			})

			const data = await res.json()

			if (!res.ok) {
				msgBox.textContent = data.message
				msgBox.classList.add('text-danger')
				return
			}

			if ((data.status = 'success')) {
				location.reload()
			} else {
				msgBox.textContent = data.message
				msgBox.classList.add('text-danger')
				return
			}
		} catch {
			msgBox.textContent = 'Something went wrong try again later'
			msgBox.classList.add('text-danger')
			return
		}
	}

	async function register(e) {
		e.preventDefault()
		const msgBox = document.getElementById('msg')
		const userData = new FormData(this)
		msgBox.textContent = ''

		try {
			const res = await fetch('http://localhost/Cart-simulation/api/register.php', {
				method: 'POST',
				body: userData,
			})

			const data = await res.json()

			if (!res.ok) {
				msgBox.textContent = data.msg
				msgBox.classList.add('text-danger')
				return
			}

			if ((data.status = 'success')) {
				location.reload()
				return
			} else {
				msgBox.textContent = data.message
				msgBox.classList.add('text-danger')
				return
			}
		} catch {
			msgBox.textContent = 'something went wrong try again later'
			msgBox.classList.add('text-danger')
			return
		}
	}

	async function logout() {
		try {
			const res = await fetch('http://localhost/Cart-simulation/api/logout.php', {
				method: 'GET',
			})

			const data = await res.json()

			if (data.status == 'success') {
				location.reload()
			}
		} catch {
			console.error('Error')
		}
	}

	document.querySelector('#cart-btn').addEventListener('click', () => {
		cartBox.classList.add('active')
	})
	document.querySelector('#close-cart').addEventListener('click', () => {
		cartBox.classList.remove('active')
	})
	checkLogin()
	cart.loadCart()
	cart.loadData()
})
