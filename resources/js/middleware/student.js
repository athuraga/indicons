import store from '~/store'

export default async (to, from, next) => {
  if (store.getters['auth/check'] && store.getters['auth/user'].role !== 'Consultant') {
    next({ name: 'index' })

    console.log(from)
  } else {
    next()
  }
}
