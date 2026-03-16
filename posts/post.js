const postEl = document.getElementById('post')
const commentsEl = document.getElementById('comments')

const renderPost = (post) => {
    postEl.innerHTML = `
        <h1>${post.title}</h1>
        <p>${post.body}</p>
    `
}

const renderComments = (comments) => {
    commentsEl.innerHTML = comments
        .map(comment => `
            <article style="padding: 12px; border: 1px solid #ddd; margin-bottom: 8px;">
                <h3>${comment.name}</h3>
                <p><strong>${comment.email}</strong></p>
                <p>${comment.body}</p>
            </article>
        `)
        .join('')
}

const getPostById = async (id) => {
    const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${id}`)

    if (!response.ok) {
        throw new Error(`Не удалось загрузить пост: ${response.status}`)
    }

    return response.json()
}

const getPostComments = async (id) => {
    const response = await fetch(`https://jsonplaceholder.typicode.com/comments?postId=${id}`)

    if (!response.ok) {
        throw new Error(`Не удалось загрузить комментарии: ${response.status}`)
    }

    return response.json()
}

const init = async () => {
    const url = new URL(window.location.href)
    const id = url.searchParams.get('id')

    if (!id) {
        postEl.innerHTML = '<p>Не передан id поста</p>'
        return
    }

    try {
        const post = await getPostById(id)
        renderPost(post)
    } catch (error) {
        console.error(error)
        postEl.innerHTML = '<p>Ошибка загрузки поста</p>'
        return
    }

    try {
        const comments = await getPostComments(id)

        if (!comments.length) {
            commentsEl.innerHTML = '<p>Комментарии отсутствуют</p>'
            return
        }

        renderComments(comments)
    } catch (error) {
        console.error(error)
        commentsEl.innerHTML = '<p>Ошибка загрузки комментариев</p>'
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}