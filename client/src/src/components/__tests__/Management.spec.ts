import { describe, it, expect } from 'vitest'

import { mount } from '@vue/test-utils'
import axios from "@/apiConfig";
import MockAdapter from 'axios-mock-adapter';
import index from '@/views/management/index.vue'

describe('Management', () => {
    let wrapper;
    let mockAxios;

    beforeEach(() => {
        mockAxios = new MockAdapter(axios);
        wrapper = mount(index);
    });

    afterEach(() => {
        mockAxios.restore();
    });

});
