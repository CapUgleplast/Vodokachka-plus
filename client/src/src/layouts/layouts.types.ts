export enum AppLayoutsEnum {
    default = "default",
    login = "login",
    error = "error",
}

export const AppLayoutToFileMap: any = {
    default: "default/defaultLayout.vue",
    login: "auth/layout.vue",
    error: "default/defaultLayout.vue",
};
