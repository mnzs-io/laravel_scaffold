export type FetchPayload = {
  path: string;
  method?: "GET" | "POST" | "PUT" | "DELETE";
  body?: {};
  headers?: {};
  cache?: boolean;
};
