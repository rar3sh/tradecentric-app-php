import { describe, expect, test } from 'vitest'
import { mount } from '@vue/test-utils';
import AddEditOrder from '../components/AddEditOrder.vue'

const wrapper = mount(AddEditOrder)

describe('Add Edit Order Form', () => {
    test('Component is rendered correctly', () => {
        const buyerName = wrapper.find('#buyer_group input')
        expect(buyerName.exists()).toBe(true)
        expect(buyerName.attributes('placeholder')).toBe('Ex: John Doe')

        const total = wrapper.find('#total_group input')
        expect(total.exists()).toBe(true)
        expect(total.attributes('placeholder')).toBe('Ex: 250')
    })

    test('Edit Component inputs', () => {
        wrapper.find('#buyer_group input').setValue('This is John')
        expect(wrapper.vm.$data['order']['buyer_name']).toBe('This is John')

        wrapper.find('#total_group input').setValue(100)
        expect(wrapper.vm.$data['order']['total']).toBe(100)
    })
})
