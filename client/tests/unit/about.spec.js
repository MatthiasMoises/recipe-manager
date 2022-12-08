import { shallowMount } from '@vue/test-utils'
import AboutView from '@/views/AboutView.vue'

describe('AboutView.vue', () => {
  it('renders render a headline if reachable', () => {
    const wrapper = shallowMount(AboutView)
    expect(wrapper.text()).toContain('This is an about page')
  })
})
