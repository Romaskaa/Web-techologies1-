import Auth from "../services/auth.js";
import location from "../services/location.js";
import loading from "../services/loading.js";
import TodoRepository from "../repository/todo.js";

let todos = []

const findTodoId = (todo) => String(todo.id ?? todo._id)

const extractTodos = (response) => {
    const payload = response?.data

    if (Array.isArray(payload)) {
        return payload
    }

    if (Array.isArray(payload?.todos)) {
        return payload.todos
    }

    if (Array.isArray(payload?.todo)) {
        return payload.todo
    }

    return []
}

const extractTodo = (response) => {
    const payload = response?.data

    if (payload?.todo) {
        return payload.todo
    }

    if (payload && typeof payload === 'object' && ('description' in payload)) {
        return payload
    }

    return null
}

const createTodoItem = (todo, listEl) => {
    const todoId = findTodoId(todo)

    const itemEl = document.createElement('li')
    itemEl.className = 'todo-list__item'
    itemEl.dataset.todoId = todoId

    const statusLabelEl = document.createElement('label')
    statusLabelEl.className = 'todo-list__status'

    const checkboxEl = document.createElement('input')
    checkboxEl.type = 'checkbox'
    checkboxEl.checked = Boolean(todo.completed)

    const descriptionEl = document.createElement('span')
    descriptionEl.className = 'todo-list__description'
    descriptionEl.innerText = todo.description

    if (checkboxEl.checked) {
        descriptionEl.classList.add('todo-list__description_completed')
    }

    const deleteBtnEl = document.createElement('button')
    deleteBtnEl.type = 'button'
    deleteBtnEl.className = 'button todo-list__delete'
    deleteBtnEl.innerText = 'Удалить'

    checkboxEl.addEventListener('click', async (event) => {
        event.preventDefault()

        const nextCompleted = !todo.completed

        checkboxEl.disabled = true
        deleteBtnEl.disabled = true

        const response = await TodoRepository.update(todoId, {
            completed: nextCompleted
        })

        if (response.ok) {
            const updatedTodo = extractTodo(response)
            todo.completed = updatedTodo?.completed ?? nextCompleted

        }
        checkboxEl.checked = Boolean(todo.completed)

        if (checkboxEl.checked) {
            descriptionEl.classList.add('todo-list__description_completed')
        } else {
            descriptionEl.classList.remove('todo-list__description_completed')
        }
        
        checkboxEl.disabled = false
        deleteBtnEl.disabled = false
    })

    deleteBtnEl.addEventListener('click', async () => {
        deleteBtnEl.disabled = true
        checkboxEl.disabled = true

        const response = await TodoRepository.delete(todoId)

        if (response.ok) {
            todos = todos.filter(currentTodo => findTodoId(currentTodo) !== todoId)
            itemEl.remove()

            if (!todos.length) {
                listEl.innerHTML = '<li class="todo-list__empty">Список todo пуст</li>'
            }
        } else {
            deleteBtnEl.disabled = false
            checkboxEl.disabled = false
        }
    })

    statusLabelEl.append(checkboxEl, descriptionEl)
    itemEl.append(statusLabelEl, deleteBtnEl)

    return itemEl
}

const renderTodos = (listEl) => {
    listEl.innerHTML = ''

    if (!todos.length) {
        listEl.innerHTML = '<li class="todo-list__empty">Список todo пуст</li>'
        return
    }

    const fragment = document.createDocumentFragment()

    todos.forEach(todo => {
        fragment.append(createTodoItem(todo, listEl))
    })

    listEl.append(fragment)
}

const init = async () => {
    const { ok: isLogged } = await Auth.me()

    if (!isLogged) {
        return location.login()
    } 

    const listEl = document.getElementById('todo-list')
    const formEl = document.getElementById('todo-form')
    const formInputEl = formEl.querySelector('input[name=description]')
    const submitBtnEl = formEl.querySelector('button[type=submit]')

    const todosResponse = await TodoRepository.getAll()

    if (todosResponse.ok) {
        todos = extractTodos(todosResponse)
    }

    renderTodos(listEl)
    loading.stop()

    formEl.addEventListener('submit', async (event) => {
        event.preventDefault()

        const description = formInputEl.value.trim()

        if (!description) {
            return
        }

        submitBtnEl.disabled = true

        const response = await TodoRepository.create({ description })
        const newTodo = extractTodo(response)

        if (response.ok && newTodo) {
            todos.push(newTodo)
            renderTodos(listEl)
            formInputEl.value = ''
        }

        submitBtnEl.disabled = false
    })
}

if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", init)
} else {
    init()
}
