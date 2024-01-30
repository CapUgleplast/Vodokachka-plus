import type { RouteLocationNormalized } from "vue-router";
import { AppLayoutsEnum, AppLayoutToFileMap } from "@/layouts/layouts.types";
import {defineAsyncComponent} from "vue";

export async function loadLayoutMiddleware(route: RouteLocationNormalized): Promise<void> {
    const { layout } = route.meta;
    const normalizedLayoutName = layout || AppLayoutsEnum.default;
    const fileName = AppLayoutToFileMap[normalizedLayoutName];
    const fileNameWithoutExtension = fileName.split(".vue")[0];
    const path = `../layouts/${fileNameWithoutExtension}.vue`
    const component = await import(path);
    route.meta.layoutComponent = component.default;
}
