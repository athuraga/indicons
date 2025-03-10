import store from '~/store'

export default async (to, from, next) => {
  if (store.getters['auth/check'] && store.getters['auth/user'].role !== 'Recruiter') {
    next({ name: 'index' })
  } else {
    next()
  }
}
