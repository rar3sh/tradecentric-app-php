import { describe, expect, test } from 'vitest';
import { PaginationModel } from "../Models/PaginationModel.ts";

describe('Pagination Model', () => {
    test('Test default properties', () => {
        let pagination = new PaginationModel();

        expect(pagination.currentPage).toBe(1);
        expect(pagination.from).toBe(1);
        expect(pagination.to).toBe(0);
        expect(pagination.lastPage).toBe(0);
        expect(pagination.total).toBe(0);
        expect(pagination.perPage).toBe(0);
    });
});
