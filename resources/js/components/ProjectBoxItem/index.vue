<template>
  <div class="project-box__container">
    <template v-if="role === 'Consultant'">
      <ProjectBoxItemWaiting v-if="data.status === 'Waiting'" :data="data" />
      <ProjectBoxItemAccepted v-else-if="data.status === 'Accepted'" :data="data" />
      <ProjectBoxItemRejected v-else-if="data.status === 'Rejected'" :data="data" />
      <ProjectBoxItemWaitingToStart v-else-if="data.status === 'Waiting to Start'" :data="data" />
      <ProjectBoxItemProjectStarted v-else-if="data.status === 'Project Started'" :data="data" />
      <ProjectBoxItemFinished v-else-if="data.status === 'Finished'" :data="data" />
      <ProjectBoxItemBailOut v-else-if="data.status === 'Bail Out'" :data="data" />
    </template>
    <template v-else>
      <ProjectBoxItemHiring v-if="data.status === 'Hiring'" :data="data" />
      <ProjectBoxItemOngoing v-else-if="data.status === 'Ongoing'" :data="data" />
      <ProjectBoxItemConfirmation v-else-if="data.status === 'Confirmation'" :data="data" />
      <ProjectBoxItemFinished v-else-if="data.status === 'Finished'" :data="data" />
      <ProjectBoxItemDraft v-else-if="data.status === 'Draft'" :data="data" />
    </template>
  </div>
</template>

<script>
import ProjectBoxItemWaiting from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemWaiting'
import ProjectBoxItemAccepted from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemAccepted'
import ProjectBoxItemRejected from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemRejected'
import ProjectBoxItemWaitingToStart from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemWaitingToStart'
import ProjectBoxItemProjectStarted from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemProjectStarted'
import ProjectBoxItemBailOut from '~/components/ProjectBoxItem/Consultant/ProjectBoxItemBailOut'
import ProjectBoxItemHiring from '~/components/ProjectBoxItem/Recruiter/ProjectBoxItemHiring'
import ProjectBoxItemOngoing from '~/components/ProjectBoxItem/Recruiter/ProjectBoxItemOngoing'
import ProjectBoxItemConfirmation from '~/components/ProjectBoxItem/Recruiter/ProjectBoxItemConfirmation'
import ProjectBoxItemFinished from '~/components/ProjectBoxItem/Recruiter/ProjectBoxItemFinished'
import ProjectBoxItemDraft from '~/components/ProjectBoxItem/Recruiter/ProjectBoxItemDraft'

export default {
  name: 'ProjectBoxItem',

  middleware: ['auth'],

  components: {
    ProjectBoxItemWaiting,
    ProjectBoxItemAccepted,
    ProjectBoxItemRejected,
    ProjectBoxItemWaitingToStart,
    ProjectBoxItemProjectStarted,
    ProjectBoxItemBailOut,
    ProjectBoxItemHiring,
    ProjectBoxItemOngoing,
    ProjectBoxItemConfirmation,
    ProjectBoxItemFinished,
    ProjectBoxItemDraft
  },

  props: {
    data: { type: Object, default: null },
    role: { type: String, default: null }
  }
}
</script>

<style scoped>

</style>
